<?php

namespace App\Policies;

use App\Models\Electrician;
use App\Models\User;

class ElectricianPolicy
{
    /**
     * Determine whether the user can view any electricians.
     */
    public function viewAny(User $user): bool
    {
        return true; // Public can view electricians list
    }

    /**
     * Determine whether the user can view the electrician.
     */
    public function view(?User $user, Electrician $electrician): bool
    {
        return true; // Public can view electrician profiles
    }

    /**
     * Determine whether the user can create electrician profiles.
     */
    public function create(User $user): bool
    {
        // Only users with electrician role can create profile
        return $user->isElectrician() && !$user->electrician;
    }

    /**
     * Determine whether the user can update the electrician profile.
     */
    public function update(User $user, Electrician $electrician): bool
    {
        // Electrician can update their own profile
        if ($user->isElectrician() && $user->electrician && $user->electrician->id === $electrician->id) {
            return true;
        }

        // Admin can update any electrician
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the electrician profile.
     */
    public function delete(User $user, Electrician $electrician): bool
    {
        // Only admin can delete electrician profiles
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can verify the electrician.
     */
    public function verify(User $user): bool
    {
        // Only admin can verify electricians
        return $user->isAdmin();
    }
}