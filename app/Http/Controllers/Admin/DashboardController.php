<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use App\Models\Electrician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard with proper data.
     */
    public function index()
    {
        // Get statistics with proper null checks
        $totalUsers = User::count() ?? 0;
        $totalElectricians = Electrician::count() ?? 0;
        $verifiedElectricians = Electrician::where('is_verified', true)->count() ?? 0;
        $pendingElectricians = Electrician::where('is_verified', false)->count() ?? 0;
        
        $totalBookings = Booking::count() ?? 0;
        $completedBookings = Booking::where('status', 'completed')->count() ?? 0;
        $pendingBookings = Booking::where('status', 'pending')->count() ?? 0;
        $confirmedBookings = Booking::where('status', 'confirmed')->count() ?? 0;
        $cancelledBookings = Booking::where('status', 'cancelled')->count() ?? 0;
        
        $totalRevenue = Booking::where('status', 'completed')->sum('total_amount') ?? 0;
        
        // Get recent bookings with eager loading - ensure it's always a collection
        $recentBookings = Booking::with(['client', 'electrician.user', 'service'])
            ->latest()
            ->limit(10)
            ->get();

        // Get recent users - ensure it's always a collection
        $recentUsers = User::latest()
            ->limit(10)
            ->get();

        // Get bookings by status for chart
        $bookingsByStatus = Booking::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Get top electricians
        $topElectricians = Electrician::with('user')
            ->withCount('bookings')
            ->withAvg('reviews', 'rating')
            ->orderBy('bookings_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalElectricians',
            'verifiedElectricians',
            'pendingElectricians',
            'totalBookings',
            'completedBookings',
            'pendingBookings',
            'confirmedBookings',
            'cancelledBookings',
            'totalRevenue',
            'recentBookings',
            'recentUsers',
            'bookingsByStatus',
            'topElectricians'
        ));
    }
}