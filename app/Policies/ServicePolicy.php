<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;

class ServicePolicy
{
    /**
     * Determine whether the user can view any services.
     */
    public function viewAny(?User $user): bool
    {
        return true; // Public can view services list
    }

    /**
     * Determine whether the user can view the service.
     */
    public function view(?User $user, Service $service): bool
    {
        return true; // Public can view service details
    }

    /**
     * Determine whether the user can create services.
     */
    public function create(User $user): bool
    {
        // Only admin can create services
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the service.
     */
    public function update(User $user, Service $service): bool
    {
        // Only admin can update services
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the service.
     */
    public function delete(User $user, Service $service): bool
    {
        // Only admin can delete services
        return $user->isAdmin();
    }
}
