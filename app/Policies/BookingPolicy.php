<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    /**
     * Determine whether the user can view any bookings.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view their own bookings list
    }

    /**
     * Determine whether the user can view the booking.
     */
    public function view(User $user, Booking $booking): bool
    {
        // Admin can view any booking
        if ($user->isAdmin()) {
            return true;
        }

        // Client can view their own bookings
        if ($user->isClient() && $user->id === $booking->client_id) {
            return true;
        }

        // Electrician can view bookings assigned to them
        if ($user->isElectrician() && $user->electrician && $user->electrician->id === $booking->electrician_id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create bookings.
     */
    public function create(User $user): bool
    {
        // Only clients can create bookings
        return $user->isClient();
    }

    /**
     * Determine whether the user can update the booking.
     */
    public function update(User $user, Booking $booking): bool
    {
        // Only admin can update booking details
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the booking.
     */
    public function delete(User $user, Booking $booking): bool
    {
        // Only admin can delete bookings
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can cancel the booking.
     */
    public function cancel(User $user, Booking $booking): bool
    {
        // Client can cancel their own pending/confirmed bookings
        if ($user->isClient() && $user->id === $booking->client_id) {
            return in_array($booking->status, ['pending', 'confirmed']);
        }

        // Electrician can cancel bookings assigned to them
        if ($user->isElectrician() && $user->electrician && $user->electrician->id === $booking->electrician_id) {
            return in_array($booking->status, ['pending', 'confirmed']);
        }

        // Admin can cancel any booking
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can confirm the booking.
     */
    public function confirm(User $user, Booking $booking): bool
    {
        // Only electrician assigned to the booking can confirm
        return $user->isElectrician() && 
               $user->electrician && 
               $user->electrician->id === $booking->electrician_id && 
               $booking->status === 'pending';
    }

    /**
     * Determine whether the user can complete the booking.
     */
    public function complete(User $user, Booking $booking): bool
    {
        // Only electrician assigned to the booking can mark as complete
        return $user->isElectrician() && 
               $user->electrician && 
               $user->electrician->id === $booking->electrician_id && 
               $booking->status === 'confirmed';
    }
}