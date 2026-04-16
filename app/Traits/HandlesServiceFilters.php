<?php

namespace App\Traits;

use App\Models\Service;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait HandlesServiceFilters
{
    /**
     * Apply filters to service query.
     */
    protected function applyServiceFilters(Builder $query, Request $request): Builder
    {
        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('base_price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('base_price', '<=', $request->max_price);
        }

        // Duration filter
        if ($request->filled('max_duration')) {
            $query->where('estimated_duration_minutes', '<=', $request->max_duration);
        }

        // Sort options
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('base_price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('base_price', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'popular':
                    $query->withCount('bookings')->orderBy('bookings_count', 'desc');
                    break;
                default:
                    $query->orderBy('name');
            }
        } else {
            $query->orderBy('name');
        }

        return $query;
    }

    /**
     * Get active service categories.
     */
    protected function getActiveCategories(): array
    {
        return Service::active()
            ->select('category_id')
            ->distinct()
            ->whereNotNull('category_id')
            ->orderBy('category_id')
            ->pluck('category_id')
            ->toArray();
    }

    /**
     * Get featured services.
     */
    protected function getFeaturedServices(int $limit = 3)
    {
        return Service::active()
            ->withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get top electricians for a service.
     */
    protected function getTopElectriciansForService(Service $service, int $limit = 6)
    {
        return $service->electricians()
            ->verified()
            ->with(['user'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->orderBy('reviews_avg_rating', 'desc')
            ->orderBy('reviews_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get related services.
     */
    protected function getRelatedServices(Service $service, int $limit = 4)
    {
        return Service::active()
            ->where('category_id', $service->category_id)
            ->where('id', '!=', $service->id)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }
}