<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store a newly created review.
     */
    public function store(Request $request, Booking $booking)
    {
        // Check if booking belongs to user and is completed
        if ($booking->client_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($booking->status !== 'completed') {
            return back()->with('error', 'You can only review completed bookings.');
        }

        if ($booking->review) {
            return back()->with('error', 'This booking has already been reviewed.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        $review = Review::create([
            'booking_id' => $booking->id,
            'client_id' => auth()->id(),
            'electrician_id' => $booking->electrician_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment']
        ]);

        // Update electrician's average rating (can be done via model events)
        
        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Thank you for your review!');
    }

    /**
     * Show the form for editing a review.
     */
    public function edit(Review $review)
    {
        if ($review->client_id !== auth()->id()) {
            abort(403);
        }

        return view('reviews.edit', compact('review'));
    }

    /**
     * Update the specified review.
     */
    public function update(Request $request, Review $review)
    {
        if ($review->client_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        $review->update($validated);

        return redirect()->route('bookings.show', $review->booking)
            ->with('success', 'Review updated successfully.');
    }

    /**
     * Remove the specified review.
     */
    public function destroy(Review $review)
    {
        if ($review->client_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $bookingId = $review->booking_id;
        $review->delete();

        return redirect()->route('bookings.show', $bookingId)
            ->with('success', 'Review deleted successfully.');
    }

    /**
     * Report a review (for moderation).
     */
    public function report(Request $request, Review $review)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        // Store report logic here
        // You might want to create a ReviewReport model

        return back()->with('success', 'Review reported. Our team will investigate.');
    }

    /**
     * Mark review as helpful.
     */
    public function markHelpful(Review $review)
    {
        // Increment helpful count
        $review->increment('helpful_count');

        return back()->with('success', 'Thanks for your feedback!');
    }
}