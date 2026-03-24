<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    /**
     * Determine whether the user can create reviews.
     */
    public function create(User $user): bool
    {
        // Only clients can create reviews
        return $user->isClient();
    }

    /**
     * Determine whether the user can update the review.
     */
    public function update(User $user, Review $review): bool
    {
        // Client can update their own review
        if ($user->isClient() && $user->id === $review->client_id) {
            return true;
        }

        // Admin can update any review
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the review.
     */
    public function delete(User $user, Review $review): bool
    {
        // Client can delete their own review
        if ($user->isClient() && $user->id === $review->client_id) {
            return true;
        }

        // Admin can delete any review
        return $user->isAdmin();
    }
}
