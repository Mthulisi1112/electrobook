<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of all users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Verification status filter
        if ($request->filled('verified')) {
            if ($request->verified === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->verified === 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }

        // Date range filter
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Sort options
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'email_asc':
                $query->orderBy('email', 'asc');
                break;
            case 'email_desc':
                $query->orderBy('email', 'desc');
                break;
            default: // latest
                $query->orderBy('created_at', 'desc');
        }

        $users = $query->paginate(15)->withQueryString();

        // Statistics for the header
        $stats = [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'electricians' => User::where('role', 'electrician')->count(),
            'clients' => User::where('role', 'client')->count(),
            'verified' => User::whereNotNull('email_verified_at')->count(),
            'unverified' => User::whereNull('email_verified_at')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,electrician,client',
            'phone' => 'nullable|string|max:20',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'phone' => $validated['phone'] ?? null,
                'email_verified_at' => now(), // Auto-verify when created by admin
            ]);

            // If user is electrician, create empty electrician profile
            if ($validated['role'] === 'electrician') {
                $user->electrician()->create([
                    'business_name' => $validated['name'] . ' Electrical Services',
                    'phone' => $validated['phone'] ?? null,
                    'is_verified' => true, // Auto-verify when created by admin
                ]);
            }

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'User created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create user: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load(['electrician', 'clientBookings' => function ($query) {
            $query->latest()->limit(10);
        }]);

        $stats = [
            'total_bookings' => $user->clientBookings()->count(),
            'completed_bookings' => $user->clientBookings()->where('status', 'completed')->count(),
            'total_reviews' => $user->reviews()->count(),
            'member_since' => $user->created_at->format('M d, Y'),
        ];

        if ($user->isElectrician() && $user->electrician) {
            $stats['electrician_bookings'] = $user->electrician->bookings()->count();
            $stats['electrician_earnings'] = $user->electrician->bookings()
                ->where('status', 'completed')
                ->sum('total_amount');
            $stats['average_rating'] = $user->electrician->reviews()->avg('rating') ?? 0;
        }

        return view('admin.users.show', compact('user', 'stats'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        if ($user->isElectrician()) {
            $user->load('electrician');
        }
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:admin,electrician,client',
            'phone' => 'nullable|string|max:20',
        ]);

        // Add password validation if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        try {
            DB::beginTransaction();

            // Update user
            $user->update($validated);

            // Handle role change to/from electrician
            if ($request->role === 'electrician' && !$user->electrician) {
                // Create electrician profile if user changed to electrician
                $user->electrician()->create([
                    'business_name' => $user->name . ' Electrical Services',
                    'phone' => $user->phone,
                    'is_verified' => true,
                ]);
            } elseif ($request->role !== 'electrician' && $user->electrician) {
                // Delete electrician profile if user changed from electrician
                $user->electrician()->delete();
            }

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'User updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update user.')
                ->withInput();
        }
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        // Check if user has active bookings
        if ($user->isClient()) {
            $activeBookings = $user->clientBookings()
                ->whereIn('status', ['pending', 'confirmed'])
                ->exists();
            
            if ($activeBookings) {
                return back()->with('error', 'Cannot delete user with active bookings.');
            }
        }

        if ($user->isElectrician() && $user->electrician) {
            $activeBookings = $user->electrician->bookings()
                ->whereIn('status', ['pending', 'confirmed'])
                ->exists();
            
            if ($activeBookings) {
                return back()->with('error', 'Cannot delete electrician with active bookings.');
            }
        }

        try {
            $user->delete();
            return redirect()->route('admin.users.index')
                ->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete user.');
        }
    }

    /**
     * Verify email for a user.
     */
    public function verifyEmail(User $user)
    {
        if ($user->hasVerifiedEmail()) {
            return back()->with('info', 'User email is already verified.');
        }

        $user->update(['email_verified_at' => now()]);

        return back()->with('success', 'Email verified successfully.');
    }

    /**
     * Unverify email for a user.
     */
    public function unverifyEmail(User $user)
    {
        if (!$user->hasVerifiedEmail()) {
            return back()->with('info', 'User email is already unverified.');
        }

        $user->update(['email_verified_at' => null]);

        return back()->with('success', 'Email verification removed.');
    }

    /**
     * Change user role.
     */
    public function changeRole(Request $request, User $user)
    {
        // Prevent changing own role
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $validated = $request->validate([
            'role' => 'required|in:admin,electrician,client',
        ]);

        try {
            DB::beginTransaction();

            $oldRole = $user->role;
            $user->update(['role' => $validated['role']]);

            // Handle role change side effects
            if ($validated['role'] === 'electrician' && !$user->electrician) {
                // Create electrician profile
                $user->electrician()->create([
                    'business_name' => $user->name . ' Electrical Services',
                    'phone' => $user->phone,
                    'is_verified' => true,
                ]);
            } elseif ($validated['role'] !== 'electrician' && $user->electrician) {
                // Delete electrician profile
                $user->electrician()->delete();
            }

            DB::commit();

            return back()->with('success', "User role changed from {$oldRole} to {$validated['role']}.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to change user role.');
        }
    }

    /**
     * Toggle user active status (suspend/activate).
     */
    public function toggleStatus(User $user)
    {
        // Prevent self-suspension
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot suspend your own account.');
        }

        $newStatus = !$user->is_active;
        $user->update(['is_active' => $newStatus]);

        $message = $newStatus ? 'User activated successfully.' : 'User suspended successfully.';

        return back()->with('success', $message);
    }

    /**
     * Bulk delete users.
     */
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        // Remove current user from the list if present
        $userIds = array_diff($validated['user_ids'], [auth()->id()]);

        if (empty($userIds)) {
            return back()->with('error', 'No valid users to delete.');
        }

        $count = User::whereIn('id', $userIds)->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "{$count} users deleted successfully.");
    }

    /**
     * Bulk verify emails.
     */
    public function bulkVerifyEmails(Request $request)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $count = User::whereIn('id', $validated['user_ids'])
            ->whereNull('email_verified_at')
            ->update(['email_verified_at' => now()]);

        return back()->with('success', "{$count} users verified successfully.");
    }

    /**
     * Export users list.
     */
    public function export(Request $request)
    {
        $query = User::query();

        // Apply filters
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->get()->map(function ($user) {
            return [
                'Name' => $user->name,
                'Email' => $user->email,
                'Role' => ucfirst($user->role),
                'Phone' => $user->phone ?? 'N/A',
                'Verified' => $user->hasVerifiedEmail() ? 'Yes' : 'No',
                'Joined Date' => $user->created_at->format('Y-m-d'),
                'Last Updated' => $user->updated_at->format('Y-m-d'),
                'Bookings (as client)' => $user->clientBookings()->count(),
            ];
        });

        // Generate CSV
        $filename = 'users-' . now()->format('Y-m-d') . '.csv';
        $handle = fopen('php://temp', 'w+');
        
        // Add headers
        if ($users->isNotEmpty()) {
            fputcsv($handle, array_keys($users->first()));
        }
        
        // Add data
        foreach ($users as $user) {
            fputcsv($handle, $user);
        }
        
        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Get user activity log.
     */
    public function activityLog(User $user)
    {
        // This would require an activity log model/trait
        // For now, return recent bookings and reviews
        $recentActivity = collect()
            ->concat($user->clientBookings()->latest()->limit(10)->get())
            ->concat($user->reviews()->latest()->limit(10)->get())
            ->sortByDesc('created_at')
            ->take(20);

        return view('admin.users.activity', compact('user', 'recentActivity'));
    }

    /**
     * Impersonate user (admin feature).
     */
    public function impersonate(User $user)
    {
        // Prevent impersonating self
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot impersonate yourself.');
        }

        session()->put('impersonate', $user->id);
        session()->put('impersonated_by', auth()->id());

        return redirect()->route('dashboard')
            ->with('info', "You are now impersonating {$user->name}.");
    }

    /**
     * Stop impersonating.
     */
    public function stopImpersonate()
    {
        if (!session()->has('impersonate')) {
            return back()->with('error', 'Not impersonating anyone.');
        }

        $impersonatedBy = session()->get('impersonated_by');
        
        session()->forget(['impersonate', 'impersonated_by']);

        if ($impersonatedBy) {
            auth()->loginUsingId($impersonatedBy);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Stopped impersonating user.');
    }
}