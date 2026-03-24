<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Electrician;
use Illuminate\Http\Request;

class ServiceElectricianController extends Controller
{
    /**
     * Display electricians for a specific service.
     */
    public function index(Request $request, Service $service)
    {
        // Check if service is active
        if (!$service->is_active) {
            abort(404);
        }

        // Get electricians that offer this service
        $electricians = Electrician::whereHas('services', function($query) use ($service) {
                $query->where('services.id', $service->id);
            })
            ->verified()
            ->with(['user', 'reviews' => function($query) {
                $query->latest()->take(3);
            }])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->withCount('bookings') // For "hires on Thumbtack" count
            ->when($request->sort, function($query, $sort) {
                if ($sort === 'rating') {
                    $query->orderBy('reviews_avg_rating', 'desc');
                } elseif ($sort === 'reviews') {
                    $query->orderBy('reviews_count', 'desc');
                }
            })
            ->paginate(10);

        // Get popular services for this category
        $popularServices = Service::whereHas('electricians', function($query) use ($service) {
                $query->where('electricians.id', $service->id);
            })
            ->active()
            ->take(5)
            ->get();

        return view('public.services.electricians', compact('service', 'electricians', 'popularServices'));
    }
}