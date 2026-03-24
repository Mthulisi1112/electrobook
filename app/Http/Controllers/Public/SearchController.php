<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Electrician;
use App\Models\Service;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request, $serviceSlug = null)
    {
        // Get search query from request
        $query = $request->get('q');
        $category = $request->get('category'); // Filter by category
        $sort = $request->get('sort', 'rating');
        
        // Start building the electricians query
        $electriciansQuery = Electrician::with(['user', 'services', 'reviews'])
            ->where('is_verified', true);
        
        // Filter by service slug if provided (for URL like /search/emergency-electrical-repair)
        if ($serviceSlug) {
            $service = Service::where('slug', $serviceSlug)->first();
            if ($service) {
                $electriciansQuery->whereHas('services', function ($query) use ($service) {
                    $query->where('services.id', $service->id);
                });
                $category = $service->category; // Set category for display
            }
        }
        
        // Filter by category (from services table)
        if ($category) {
            $electriciansQuery->whereHas('services', function ($query) use ($category) {
                $query->where('services.category', $category);
            });
        }
        
        // Filter by search query (business name, bio, or service name)
        if ($query) {
            $electriciansQuery->where(function ($q) use ($query) {
                $q->where('business_name', 'like', "%{$query}%")
                  ->orWhere('bio', 'like', "%{$query}%")
                  ->orWhereHas('user', function ($userQuery) use ($query) {
                      $userQuery->where('name', 'like', "%{$query}%");
                  })
                  ->orWhereHas('services', function ($serviceQuery) use ($query) {
                      $serviceQuery->where('services.name', 'like', "%{$query}%");
                  });
            });
        }
        
        // Apply sorting
        switch ($sort) {
            case 'rating':
                $electriciansQuery->withAvg('reviews', 'rating')
                    ->orderBy('reviews_avg_rating', 'desc');
                break;
            case 'price_low':
                $electriciansQuery->orderBy('hourly_rate', 'asc');
                break;
            case 'price_high':
                $electriciansQuery->orderBy('hourly_rate', 'desc');
                break;
            case 'experience':
                $electriciansQuery->orderBy('years_experience', 'desc');
                break;
            case 'reviews':
                $electriciansQuery->withCount('reviews')
                    ->orderBy('reviews_count', 'desc');
                break;
            default:
                $electriciansQuery->withAvg('reviews', 'rating')
                    ->orderBy('reviews_avg_rating', 'desc');
                break;
        }
        
        // Paginate results (12 per page)
        $electricians = $electriciansQuery->paginate(12);
        
        // Get all unique categories from services for filter options
        $categories = Service::distinct()->pluck('category');
        
        // Get the current service if filtering by service
        $currentService = null;
        if ($serviceSlug) {
            $currentService = Service::where('slug', $serviceSlug)->first();
        }
        
        // Get search statistics
        $totalResults = $electricians->total();
        
        return view('public.search.index', compact(
            'electricians', 
            'categories', 
            'query',
            'category',
            'sort',
            'totalResults',
            'currentService'
        ));
    }
}