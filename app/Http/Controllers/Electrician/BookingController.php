<?php

namespace App\Http\Controllers\Electrician;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of bookings.
     */
    public function index(Request $request)
    {
        $electrician = auth()->user()->electrician;
        
        $query = $electrician->bookings()
            ->with(['client', 'service']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('booking_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('booking_date', '<=', $request->to_date);
        }

        $bookings = $query->orderBy('booking_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(15);

        $stats = [
            'pending' => $electrician->bookings()->where('status', 'pending')->count(),
            'confirmed' => $electrician->bookings()->where('status', 'confirmed')->count(),
            'completed' => $electrician->bookings()->where('status', 'completed')->count(),
            'cancelled' => $electrician->bookings()->where('status', 'cancelled')->count(),
        ];

        return view('electrician.bookings.index', compact('bookings', 'stats'));
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        $electrician = auth()->user()->electrician;

        if ($booking->electrician_id !== $electrician->id) {
            abort(403);
        }

        $booking->load(['client', 'service', 'review']);

        return view('electrician.bookings.show', compact('booking'));
    }

    /**
     * Confirm a booking.
     */
    public function confirm(Booking $booking)
    {
        $electrician = auth()->user()->electrician;

        if ($booking->electrician_id !== $electrician->id) {
            abort(403);
        }

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be confirmed.');
        }

        $booking->update(['status' => 'confirmed']);

        return back()->with('success', 'Booking confirmed successfully.');
    }

    /**
     * Complete a booking.
     */
    public function complete(Booking $booking)
    {
        $electrician = auth()->user()->electrician;

        if ($booking->electrician_id !== $electrician->id) {
            abort(403);
        }

        if ($booking->status !== 'confirmed') {
            return back()->with('error', 'Only confirmed bookings can be marked as complete.');
        }

        $booking->update(['status' => 'completed']);

        return back()->with('success', 'Booking marked as completed.');
    }

    /**
     * Cancel a booking.
     */
    public function cancel(Request $request, Booking $booking)
    {
        $electrician = auth()->user()->electrician;

        if ($booking->electrician_id !== $electrician->id) {
            abort(403);
        }

        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'This booking cannot be cancelled.');
        }

        $validated = $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        DB::transaction(function () use ($booking, $validated) {
            $booking->update([
                'status' => 'cancelled',
                'cancellation_reason' => $validated['cancellation_reason'],
                'cancelled_at' => now(),
            ]);

            // Free up the slot
            if ($booking->availabilitySlot) {
                $booking->availabilitySlot->update(['is_booked' => false]);
            }
        });

        return back()->with('success', 'Booking cancelled successfully.');
    }
}