<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Category; 
use App\Traits\HandlesServiceFilters;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use HandlesServiceFilters;

    /**
     * Display a listing of active services.
     */
    public function index(Request $request)
    {
        // Authorization - anyone can view services
        $this->authorize('viewAny', Service::class);

        $query = Service::query()->active();

        // Apply filters using trait
        $query = $this->applyServiceFilters($query, $request);

        // Get categories for filter dropdown
        $categories = $this->getActiveCategories();

        // Paginate results
        $services = $query->paginate(12)->withQueryString();

        // Get featured services for sidebar
        $featuredServices = $this->getFeaturedServices(3);

        return view('public.services.index', compact(
            'services', 
            'categories', 
            'featuredServices'
        ));
    }

    /**
     * Display the specified service.
     */
       public function show(Service $service)
    {
        // Check if service is active
        if (!$service->is_active) {
            abort(404);
        }

        // Authorization - anyone can view service details
        $this->authorize('view', $service);

        // Load relationships efficiently
        $service->load([
            'electricians' => function ($query) {
                $query->verified()
                    ->with(['user', 'reviews'])
                    ->withAvg('reviews', 'rating')
                    ->withCount('reviews')
                    ->take(5);
            },
            'categories' => function ($query) {
                $query->with('children')->ordered();
            }
        ]);

        // Organize categories by type for Thumbtack layout
        $groupedCategories = [
            'Interior' => $service->categories->where('type', 'interior'),
            'Exterior' => $service->categories->where('type', 'exterior'),
            'General Contracting' => $service->categories->where('type', 'contracting'),
        ];

        // If no categories assigned, use some defaults
        if ($service->categories->isEmpty()) {
            $groupedCategories = [
                'Interior' => [
                    (object)['name' => 'Home Repairs & Maintenance', 'slug' => 'home-repairs'],
                    (object)['name' => 'Cleaning & Organization', 'slug' => 'cleaning'],
                    (object)['name' => 'Renovations & Upgrades', 'slug' => 'renovations'],
                ],
                'Exterior' => [
                    (object)['name' => 'Exterior Home Care', 'slug' => 'exterior-care'],
                    (object)['name' => 'Landscaping & Outdoor Services', 'slug' => 'landscaping'],
                    (object)['name' => 'Moving', 'slug' => 'moving'],
                    (object)['name' => 'Installation & Assembly', 'slug' => 'installation'],
                ],
                'General Contracting' => [
                    (object)['name' => 'Carpenters', 'slug' => 'carpenters'],
                    (object)['name' => 'Bathroom Remodeling', 'slug' => 'bathroom-remodeling'],
                    (object)['name' => 'Kitchen Remodeling', 'slug' => 'kitchen-remodeling'],
                    (object)['name' => 'Flooring Installation', 'slug' => 'flooring'],
                    (object)['name' => 'Interior Design', 'slug' => 'interior-design'],
                    (object)['name' => 'Carpet Installation', 'slug' => 'carpet'],
                    (object)['name' => 'Interior Painting', 'slug' => 'painting'],
                    (object)['name' => 'Basement Remodeling', 'slug' => 'basement'],
                ],
            ];
        }

        // Get service statistics
        $statistics = $this->getServiceStatistics($service);

        return view('public.services.show', compact(
            'service',
            'groupedCategories',
            'statistics'
        ));
    }

    /**
     * Get service statistics.
     */
    private function getServiceStatistics(Service $service): array
    {
        return [
            'total_bookings' => $service->bookings()->count(),
            'completed_bookings' => $service->bookings()->completed()->count(),
            'average_rating' => $service->electricians()
                ->withAvg('reviews', 'rating')
                ->get()
                ->avg('reviews_avg_rating') ?? 0,
            'available_electricians' => $service->electricians()
                ->verified()
                ->count(),
        ];
    }
}