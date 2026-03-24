<?php

namespace App\Policies;

use App\Models\AvailabilitySlot;
use App\Models\User;

class AvailabilitySlotPolicy
{
    /**
     * Determine whether the user can view any availability slots.
     */
    public function viewAny(?User $user, int $electricianId): bool
    {
        return true; // Public can view availability slots for booking
    }

    /**
     * Determine whether the user can create availability slots.
     */
    public function create(User $user): bool
    {
        // Only electricians can create availability slots
        return $user->isElectrician();
    }

    /**
     * Determine whether the user can update the availability slot.
     */
    public function update(User $user, AvailabilitySlot $availabilitySlot): bool
    {
        // Electrician can update their own slots
        if ($user->isElectrician() && $user->electrician && $user->electrician->id === $availabilitySlot->electrician_id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the availability slot.
     */
    public function delete(User $user, AvailabilitySlot $availabilitySlot): bool
    {
        // Electrician can delete their own slots
        if ($user->isElectrician() && $user->electrician && $user->electrician->id === $availabilitySlot->electrician_id) {
            return !$availabilitySlot->is_booked; // Can't delete booked slots
        }

        return false;
    }
}
