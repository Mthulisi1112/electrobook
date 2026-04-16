<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Try to fetch from database, fallback to manual list
        $popularServices = Service::where('is_popular', true)
            ->orWhere('usage_count', '>', 10)
            ->limit(4)
            ->get(['id', 'name', 'slug', 'description', 'image']);

        // If the query returns empty or the table doesn't exist, use a fallback
        if ($popularServices->isEmpty()) {
            $popularServices = collect([
                (object) [
                    'slug'        => 'emergency-repair',
                    'name'        => 'Emergency repair',
                    'image'       => 'https://images.unsplash.com/photo-1621905252507-b35492cc74b4?auto=format&fit=crop&w=500&h=400&q=80',
                    'description' => '24/7 service available'
                ],
                (object) [
                    'slug'        => 'panel-upgrade',
                    'name'        => 'Panel upgrade',
                    'image'       => 'https://images.unsplash.com/photo-1581094288338-2314dddb7ece?auto=format&fit=crop&w=500&h=400&q=80',
                    'description' => 'Increase capacity & safety'
                ],
                (object) [
                    'slug'        => 'lighting-installation',
                    'name'        => 'Lighting installation',
                    'image'       => 'https://images.unsplash.com/photo-1567427017947-545c5f8d16ad?auto=format&fit=crop&w=500&h=400&q=80',
                    'description' => 'Indoor & outdoor'
                ],
                (object) [
                    'slug'        => 'wiring-rewiring',
                    'name'        => 'Wiring & rewiring',
                    'image'       => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?auto=format&fit=crop&w=500&h=400&q=80',
                    'description' => 'Safe & up to code'
                ],
            ]);
        }
        return view('home', compact('popularServices'));
    }
}
