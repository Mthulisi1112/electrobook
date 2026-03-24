<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Electrician;
use App\Models\Service;
use App\Traits\HandlesElectricianFilters;
use Illuminate\Http\Request;

class ElectricianController extends Controller
{
    use HandlesElectricianFilters;

    /**
     * Display a listing of verified electricians.
     */
    public function index(Request $request)
    {
        // Authorization - anyone can view electricians
        $this->authorize('viewAny', Electrician::class);

        $query = Electrician::query()->verified()->with(['user', 'reviews']);

        // Apply filters using trait
        $query = $this->applyElectricianFilters($query, $request);

        // Get filter data for dropdowns
        $services = Service::active()->get();
        $serviceAreas = $this->getUniqueServiceAreas();

        // Paginate results
        $electricians = $query->paginate(12)->withQueryString();

        // Get statistics
        $statistics = $this->getElectricianStatistics();

        return view('public.electricians.index', compact(
            'electricians',
            'services',
            'serviceAreas',
            'statistics'
        ));
    }

    /**
     * Display the specified electrician.
     */
    public function show(Electrician $electrician)
    {
        // Check if electrician is verified
        if (!$electrician->is_verified) {
            abort(404);
        }

        // Authorization - anyone can view electrician details
        $this->authorize('view', $electrician);

        // Load relationships efficiently
        $electrician->load([
            'user',
            'services',
            'reviews' => function ($query) {
                $query->latest()->with('client')->limit(10);
            }
        ]);

        // Get available slots for next 7 days
        $availableSlots = $this->getAvailableSlots($electrician);

        // Calculate ratings
        $ratings = $this->calculateRatings($electrician);

        // Get similar electricians
        $similarElectricians = $this->getSimilarElectricians($electrician);

        // Get service-specific pricing
        $servicePricing = $this->getServicePricing($electrician);

        return view('public.electricians.show', compact(
            'electrician',
            'availableSlots',
            'ratings',
            'similarElectricians',
            'servicePricing'
        ));
    }

    /**
     * Get available slots for electrician.
     */
    private function getAvailableSlots(Electrician $electrician, int $days = 7)
    {
        return $electrician->availabilitySlots()
            ->available()
            ->whereBetween('date', [now(), now()->addDays($days)])
            ->orderBy('date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(function ($slot) {
                return $slot->date->format('Y-m-d');
            });
    }

    /**
     * Calculate rating distribution.
     */
    private function calculateRatings(Electrician $electrician): array
    {
        $total = $electrician->reviews()->count();
        
        if ($total === 0) {
            return [
                'average' => 0,
                'total' => 0,
                'distribution' => array_fill(1, 5, 0)
            ];
        }

        $distribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $distribution[$i] = $electrician->reviews()
                ->where('rating', $i)
                ->count();
        }

        return [
            'average' => round($electrician->reviews()->avg('rating'), 1),
            'total' => $total,
            'distribution' => $distribution
        ];
    }

    /**
     * Get similar electricians.
     */
    private function getSimilarElectricians(Electrician $electrician, int $limit = 3)
    {
        return Electrician::verified()
            ->where('id', '!=', $electrician->id)
            ->where(function ($query) use ($electrician) {
                // Same service areas
                 if ($electrician->service_areas && is_array($electrician->service_areas) && count($electrician->service_areas) > 0) {
                    foreach ($electrician->service_areas as $area) {
                        $query->orWhereJsonContains('service_areas', $area);
                    }
                }
            })
            ->with(['user'])
            ->withAvg('reviews', 'rating')
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    /**
     * Get service pricing for electrician.
     */
    private function getServicePricing(Electrician $electrician)
    {
        return $electrician->services()
            ->get()
            ->map(function ($service) use ($electrician) {
                return (object) [
                    'id' => $service->id,
                    'name' => $service->name,
                    'base_price' => $service->base_price,
                    'electrician_price' => $service->pivot->price ?? $service->base_price,
                    'duration' => $service->pivot->duration_minutes ?? $service->estimated_duration_minutes,
                ];
            });
    }
}