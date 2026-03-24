<?php

namespace App\Traits;

use App\Models\Electrician;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait HandlesElectricianFilters
{
    /**
     * Apply filters to electrician query.
     */
    protected function applyElectricianFilters(Builder $query, Request $request): Builder
    {
        // Search by name or business name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('business_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by service
        if ($request->filled('service')) {
            $query->whereHas('services', function ($q) use ($request) {
                $q->where('services.id', $request->service);
            });
        }

        // Filter by service area
        if ($request->filled('area')) {
            $query->whereJsonContains('service_areas', $request->area);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('hourly_rate', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('hourly_rate', '<=', $request->max_price);
        }

        // Filter by availability
        if ($request->boolean('available_now')) {
            $query->whereHas('availabilitySlots', function ($q) {
                $q->where('is_booked', false)
                  ->whereDate('date', today());
            });
        }

        // Fix: Handle min_rating filter without using HAVING
        if ($request->filled('min_rating')) {
            $query->whereHas('reviews', function ($q) use ($request) {
                $q->select(DB::raw('avg(rating) as avg_rating'))
                  ->groupBy('electrician_id')
                  ->havingRaw('avg(rating) >= ?', [$request->min_rating]);
            });
        }

        // Always include ratings for sorting
        $query->withAvg('reviews', 'rating')
              ->withCount('reviews');

        // Apply sorting
        $query = $this->applyElectricianSorting($query, $request);

        return $query;
    }

    /**
     * Apply sorting to electrician query.
     */
    protected function applyElectricianSorting(Builder $query, Request $request): Builder
    {
        switch ($request->get('sort', 'recommended')) {
            case 'rating':
                $query->orderBy('reviews_avg_rating', 'desc');
                break;
            case 'experience':
                $query->orderBy('years_experience', 'desc');
                break;
            case 'price_low':
                $query->orderBy('hourly_rate', 'asc');
                break;
            case 'price_high':
                $query->orderBy('hourly_rate', 'desc');
                break;
            case 'reviews':
                $query->orderBy('reviews_count', 'desc');
                break;
            default:
                // Recommended: mix of rating and experience
                $query->orderBy('reviews_avg_rating', 'desc')
                      ->orderBy('years_experience', 'desc')
                      ->orderBy('reviews_count', 'desc');
        }

        return $query;
    }

    /**
     * Get unique service areas from all electricians.
     */
    protected function getUniqueServiceAreas(): array
    {
        $areas = [];
        
        Electrician::verified()
            ->whereNotNull('service_areas')
            ->chunk(100, function ($electricians) use (&$areas) {
                foreach ($electricians as $electrician) {
                    if (is_array($electrician->service_areas)) {
                        $areas = array_merge($areas, $electrician->service_areas);
                    }
                }
            });

        return array_unique($areas);
    }

    /**
     * Get electrician statistics.
     */
    protected function getElectricianStatistics(): array
    {
        return [
            'total' => Electrician::verified()->count(),
            'avg_rating' => Electrician::verified()
                ->withAvg('reviews', 'rating')
                ->get()
                ->avg('reviews_avg_rating') ?? 0,
            'total_reviews' => \App\Models\Review::count(),
            'avg_experience' => Electrician::verified()
                ->avg('years_experience') ?? 0,
        ];
    }
}