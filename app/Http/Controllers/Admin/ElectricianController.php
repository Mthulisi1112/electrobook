<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Electrician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ElectricianController extends Controller
{
    /**
     * Display a listing of all electricians.
     */
    public function index(Request $request)
    {
        $query = Electrician::with('user');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('business_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Verification status filter
        if ($request->filled('verification')) {
            if ($request->verification === 'verified') {
                $query->where('is_verified', true);
            } elseif ($request->verification === 'pending') {
                $query->where('is_verified', false);
            }
        }

        // Sort options
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('business_name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('business_name', 'desc');
                break;
            case 'rating':
                $query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc');
                break;
            case 'bookings':
                $query->withCount('bookings')->orderBy('bookings_count', 'desc');
                break;
            default: // latest
                $query->orderBy('created_at', 'desc');
        }

        $electricians = $query->paginate(15)->withQueryString();

        // Statistics for the header
        $stats = [
            'total' => Electrician::count(),
            'verified' => Electrician::where('is_verified', true)->count(),
            'pending' => Electrician::where('is_verified', false)->count(),
            'suspended' => Electrician::where('is_suspended', true)->count() ?? 0,
        ];

        return view('admin.electricians.index', compact('electricians', 'stats'));
    }

    /**
     * Show the form for creating a new electrician.
     */
    public function create()
    {
        return view('admin.electricians.create');
    }

    /**
     * Store a newly created electrician.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'business_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'license_number' => 'required|string|max:100',
            'years_experience' => 'required|integer|min:0|max:100',
            'hourly_rate' => 'required|numeric|min:0',
            'bio' => 'nullable|string|max:2000',
            'service_areas' => 'nullable|array',
            'service_areas.*' => 'string|max:100',
        ]);

        try {
            DB::beginTransaction();

            // Create user account
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'electrician',
                'phone' => $validated['phone'],
                'email_verified_at' => now(), // Auto-verify when created by admin
            ]);

            // Create electrician profile
            $electrician = Electrician::create([
                'user_id' => $user->id,
                'business_name' => $validated['business_name'],
                'phone' => $validated['phone'],
                'license_number' => $validated['license_number'],
                'years_experience' => $validated['years_experience'],
                'hourly_rate' => $validated['hourly_rate'],
                'bio' => $validated['bio'] ?? null,
                'service_areas' => $validated['service_areas'] ?? [],
                'is_verified' => true, // Auto-verify when created by admin
            ]);

            DB::commit();

            return redirect()->route('admin.electricians.index')
                ->with('success', 'Electrician created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create electrician: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified electrician.
     */
    public function show(Electrician $electrician)
    {
        $electrician->load([
            'user',
            'services',
            'reviews' => function ($query) {
                $query->latest()->with('client')->limit(10);
            },
            'bookings' => function ($query) {
                $query->latest()->limit(10);
            }
        ]);

        $stats = [
            'total_bookings' => $electrician->bookings()->count(),
            'completed_bookings' => $electrician->bookings()->where('status', 'completed')->count(),
            'cancelled_bookings' => $electrician->bookings()->where('status', 'cancelled')->count(),
            'total_earnings' => $electrician->bookings()->where('status', 'completed')->sum('total_amount'),
            'average_rating' => $electrician->reviews()->avg('rating') ?? 0,
            'total_reviews' => $electrician->reviews()->count(),
            'available_slots' => $electrician->availabilitySlots()->where('is_booked', false)->where('date', '>=', now())->count(),
        ];

        return view('admin.electricians.show', compact('electrician', 'stats'));
    }

    /**
     * Show the form for editing the specified electrician.
     */
    public function edit(Electrician $electrician)
    {
        $electrician->load('user');
        return view('admin.electricians.edit', compact('electrician'));
    }

    /**
     * Update the specified electrician.
     */
    public function update(Request $request, Electrician $electrician)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $electrician->user_id,
            'business_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'license_number' => 'required|string|max:100',
            'years_experience' => 'required|integer|min:0|max:100',
            'hourly_rate' => 'required|numeric|min:0',
            'bio' => 'nullable|string|max:2000',
            'service_areas' => 'nullable|array',
            'service_areas.*' => 'string|max:100',
        ]);

        try {
            DB::beginTransaction();

            // Update user
            $electrician->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
            ]);

            // Update electrician
            $electrician->update([
                'business_name' => $validated['business_name'],
                'phone' => $validated['phone'],
                'license_number' => $validated['license_number'],
                'years_experience' => $validated['years_experience'],
                'hourly_rate' => $validated['hourly_rate'],
                'bio' => $validated['bio'] ?? null,
                'service_areas' => $validated['service_areas'] ?? [],
            ]);

            DB::commit();

            return redirect()->route('admin.electricians.index')
                ->with('success', 'Electrician updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update electrician.')
                ->withInput();
        }
    }

    /**
     * Remove the specified electrician.
     */
    public function destroy(Electrician $electrician)
    {
        // Check if electrician has any bookings
        $hasBookings = $electrician->bookings()->exists();
        
        if ($hasBookings) {
            return back()->with('error', 'Cannot delete electrician with existing bookings. Consider suspending instead.');
        }

        try {
            DB::beginTransaction();
            
            // Delete associated user (this will cascade to electrician due to foreign key)
            $electrician->user->delete();
            
            DB::commit();

            return redirect()->route('admin.electricians.index')
                ->with('success', 'Electrician deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete electrician.');
        }
    }

    /**
     * Verify an electrician.
     */
    public function verify(Electrician $electrician)
    {
        $electrician->update(['is_verified' => true]);

        // Send notification email to electrician

        return back()->with('success', 'Electrician verified successfully.');
    }

    /**
     * Suspend an electrician.
     */
    public function suspend(Request $request, Electrician $electrician)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        // Add suspended field if you have it, or use a status field
        $electrician->update([
            'is_suspended' => true,
            'suspension_reason' => $validated['reason'],
            'suspended_at' => now(),
        ]);

        // Send notification email to electrician

        return back()->with('warning', 'Electrician suspended successfully.');
    }

    /**
     * Reinstate a suspended electrician.
     */
    public function reinstate(Electrician $electrician)
    {
        $electrician->update([
            'is_suspended' => false,
            'suspension_reason' => null,
            'suspended_at' => null,
        ]);

        // Send notification email to electrician

        return back()->with('success', 'Electrician reinstated successfully.');
    }

    /**
     * Toggle verification status.
     */
    public function toggleVerification(Electrician $electrician)
    {
        $newStatus = !$electrician->is_verified;
        $electrician->update(['is_verified' => $newStatus]);

        $message = $newStatus ? 'Electrician verified successfully.' : 'Electrician verification removed.';

        return back()->with('success', $message);
    }

    /**
     * Show verification requests (pending electricians).
     */
    public function verificationRequests()
    {
        $pendingElectricians = Electrician::with('user')
            ->where('is_verified', false)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.electricians.verification-requests', compact('pendingElectricians'));
    }

    /**
     * Bulk verify electricians.
     */
    public function bulkVerify(Request $request)
    {
        $validated = $request->validate([
            'electrician_ids' => 'required|array',
            'electrician_ids.*' => 'exists:electricians,id',
        ]);

        $count = Electrician::whereIn('id', $validated['electrician_ids'])
            ->update(['is_verified' => true]);

        return redirect()->route('admin.electricians.verification-requests')
            ->with('success', "{$count} electricians verified successfully.");
    }

    /**
     * Export electricians list.
     */
    public function export(Request $request)
    {
        $electricians = Electrician::with('user')
            ->get()
            ->map(function ($electrician) {
                return [
                    'Business Name' => $electrician->business_name,
                    'Owner Name' => $electrician->user->name,
                    'Email' => $electrician->user->email,
                    'Phone' => $electrician->phone,
                    'License' => $electrician->license_number,
                    'Experience' => $electrician->years_experience,
                    'Hourly Rate' => $electrician->hourly_rate,
                    'Verified' => $electrician->is_verified ? 'Yes' : 'No',
                    'Service Areas' => is_array($electrician->service_areas) 
                        ? implode(', ', $electrician->service_areas) 
                        : '',
                    'Joined Date' => $electrician->created_at->format('Y-m-d'),
                ];
            });

        // Generate CSV
        $filename = 'electricians-' . now()->format('Y-m-d') . '.csv';
        $handle = fopen('php://temp', 'w+');
        
        // Add headers
        fputcsv($handle, array_keys($electricians->first() ?? []));
        
        // Add data
        foreach ($electricians as $electrician) {
            fputcsv($handle, $electrician);
        }
        
        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}