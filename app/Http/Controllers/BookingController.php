<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Electrician;
use App\Models\Service;
use App\Models\AvailabilitySlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation;
use App\Mail\BookingNotification;
use App\Mail\BookingCancelled;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
  
    /**
     * Display a listing of bookings.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $query = Booking::with(['electrician.user', 'service', 'review']);

        // Filter based on user role
        if ($user->isElectrician()) {
            $query->where('electrician_id', $user->electrician->id);
        } elseif ($user->isClient()) {
            $query->where('client_id', $user->id);
        }
        // Admin sees all bookings (no filter)

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply date range filter
        if ($request->filled('from_date')) {
            $query->whereDate('booking_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('booking_date', '<=', $request->to_date);
        }

        // Sort options
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('booking_date', 'asc');
                break;
            case 'date_desc':
                $query->orderBy('booking_date', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $bookings = $query->paginate(10)->withQueryString();

        // Get statistics for the user
        $stats = $this->getBookingStats($user);

        return view('bookings.index', compact('bookings', 'stats'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create(Request $request)
    {
        $electricians = Electrician::with('user')
            ->where('is_verified', true)
            ->get();
        
        $services = Service::where('is_active', true)->get();
        
        // Preselect electrician if provided in URL
        $selectedElectrician = null;
        if ($request->filled('electrician_id')) {
            $selectedElectrician = Electrician::find($request->electrician_id);
        }

        // Preselect service if provided in URL
        $selectedService = null;
        if ($request->filled('service_id')) {
            $selectedService = Service::find($request->service_id);
        }
        
        return view('bookings.create', compact(
            'electricians', 
            'services', 
            'selectedElectrician', 
            'selectedService'
        ));
    }

    /**
     * Store a newly created booking.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'electrician_id' => 'required|exists:electricians,id',
            'service_id' => 'required|exists:services,id',
            'availability_slot_id' => 'required|exists:availability_slots,id',
            'description' => 'nullable|string|max:1000',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
        ]);

        try {
            DB::beginTransaction();

            $slot = AvailabilitySlot::lockForUpdate()->findOrFail($validated['availability_slot_id']);
            
            if ($slot->is_booked) {
                return back()->with('error', 'This time slot is no longer available.')
                    ->withInput();
            }

            $service = Service::findOrFail($validated['service_id']);
            
            $booking = Booking::create([
                'client_id' => auth()->id(),
                'electrician_id' => $validated['electrician_id'],
                'service_id' => $validated['service_id'],
                'availability_slot_id' => $slot->id,
                'booking_date' => $slot->date,
                'start_time' => $slot->start_time,
                'end_time' => $slot->end_time,
                'description' => $validated['description'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'total_amount' => $service->base_price,
                'status' => 'pending',
                'booking_reference' => 'EB-' . strtoupper(Str::random(6)),
            ]);

            $slot->update(['is_booked' => true]);

            DB::commit();

            return redirect()->route('bookings.success', $booking)
                ->with('success', 'Booking created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create booking. Please try again.')
                ->withInput();
        }
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        
        $booking->load(['electrician.user', 'service', 'client', 'review', 'availabilitySlot']);
        
        // Check if user can leave a review
        $canReview = auth()->user()->isClient() && 
                    $booking->client_id === auth()->id() && 
                    $booking->status === 'completed' && 
                    !$booking->review;

        return view('bookings.show', compact('booking', 'canReview'));
    }

    /**
     * Cancel a booking.
     */
    public function cancel(Request $request, Booking $booking)
    {
        $this->authorize('cancel', $booking);

        if (!$booking->canBeCancelled()) {
            return back()->with('error', 'This booking cannot be cancelled.');
        }

        $request->validate([
            'cancellation_reason' => 'required|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $booking->update([
                'status' => 'cancelled',
                'cancellation_reason' => $request->cancellation_reason,
                'cancelled_at' => now()
            ]);

            // Free up the availability slot
            if ($booking->availabilitySlot) {
                $booking->availabilitySlot->update(['is_booked' => false]);
            }

            // Send cancellation emails
            // Mail::to($booking->client->email)->send(new BookingCancelled($booking));
            // Mail::to($booking->electrician->user->email)->send(new BookingCancelled($booking));

            DB::commit();

            return back()->with('success', 'Booking cancelled successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to cancel booking.');
        }
    }

    /**
     * Confirm a booking (electrician action).
     */
    public function confirm(Booking $booking)
    {
        $this->authorize('confirm', $booking);

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be confirmed.');
        }

        $booking->update(['status' => 'confirmed']);

        return back()->with('success', 'Booking confirmed.');
    }

    /**
     * Complete a booking (electrician action).
     */
    public function complete(Booking $booking)
    {
        $this->authorize('complete', $booking);

        if ($booking->status !== 'confirmed') {
            return back()->with('error', 'Only confirmed bookings can be marked as complete.');
        }

        $booking->update(['status' => 'completed']);

        return back()->with('success', 'Booking marked as completed.');
    }

    /**
     * Get booking statistics for user.
     */
    private function getBookingStats($user)
    {
        $stats = [];

        if ($user->isClient()) {
            $stats = [
                'total' => Booking::where('client_id', $user->id)->count(),
                'pending' => Booking::where('client_id', $user->id)->where('status', 'pending')->count(),
                'confirmed' => Booking::where('client_id', $user->id)->where('status', 'confirmed')->count(),
                'completed' => Booking::where('client_id', $user->id)->where('status', 'completed')->count(),
                'cancelled' => Booking::where('client_id', $user->id)->where('status', 'cancelled')->count(),
            ];
        } elseif ($user->isElectrician() && $user->electrician) {
            $stats = [
                'total' => Booking::where('electrician_id', $user->electrician->id)->count(),
                'pending' => Booking::where('electrician_id', $user->electrician->id)->where('status', 'pending')->count(),
                'confirmed' => Booking::where('electrician_id', $user->electrician->id)->where('status', 'confirmed')->count(),
                'completed' => Booking::where('electrician_id', $user->electrician->id)->where('status', 'completed')->count(),
                'cancelled' => Booking::where('electrician_id', $user->electrician->id)->where('status', 'cancelled')->count(),
            ];
        } elseif ($user->isAdmin()) {
            $stats = [
                'total' => Booking::count(),
                'pending' => Booking::where('status', 'pending')->count(),
                'confirmed' => Booking::where('status', 'confirmed')->count(),
                'completed' => Booking::where('status', 'completed')->count(),
                'cancelled' => Booking::where('status', 'cancelled')->count(),
            ];
        }

        return $stats;
    }

    public function success(Booking $booking)
    {
        // Ensure the booking belongs to the authenticated user
        if ($booking->client_id !== Auth::id()) {
            abort(403);
        }

        $booking->load(['electrician', 'service']);

        return view('bookings.success', compact('booking'));
    }
}