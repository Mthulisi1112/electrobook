<?php

namespace App\Traits;

use App\Models\Booking;
use App\Models\Electrician;
use App\Models\User;
use Illuminate\Support\Facades\DB;

trait DashboardQueries
{
    /**
     * Get client statistics
     */
    protected function getClientStats($userId)
    {
        return [
            'totalBookings' => Booking::where('client_id', $userId)->count(),
            'completedBookings' => Booking::where('client_id', $userId)
                ->where('status', 'completed')
                ->count(),
            'upcomingBookings' => Booking::where('client_id', $userId)
                ->whereIn('status', ['pending', 'confirmed'])
                ->where('booking_date', '>=', now())
                ->count(),
            'totalSpent' => Booking::where('client_id', $userId)
                ->where('status', 'completed')
                ->sum('total_amount'),
        ];
    }

    /**
     * Get electrician statistics
     */
    protected function getElectricianStats($electricianId)
    {
        return [
            'totalBookings' => Booking::where('electrician_id', $electricianId)->count(),
            'completedBookings' => Booking::where('electrician_id', $electricianId)
                ->where('status', 'completed')
                ->count(),
            'upcomingBookings' => Booking::where('electrician_id', $electricianId)
                ->whereIn('status', ['pending', 'confirmed'])
                ->where('booking_date', '>=', now())
                ->count(),
            'totalEarnings' => Booking::where('electrician_id', $electricianId)
                ->where('status', 'completed')
                ->sum('total_amount'),
            'averageRating' => \App\Models\Review::where('electrician_id', $electricianId)
                ->avg('rating') ?? 0,
        ];
    }

    /**
     * Get admin statistics
     */
    protected function getAdminStats()
    {
        return [
            'totalUsers' => User::count(),
            'totalElectricians' => Electrician::count(),
            'totalBookings' => Booking::count(),
            'totalRevenue' => Booking::where('status', 'completed')->sum('total_amount'),
            'pendingVerifications' => Electrician::where('is_verified', false)->count(),
        ];
    }

    /**
     * Get chart data for admin
     */
    protected function getChartData()
    {
        $currentYear = now()->year;

        $monthlyBookings = [];
        $monthlyRevenue = [];

        for ($month = 1; $month <= 12; $month++) {
            $monthStr = str_pad($month, 2, '0', STR_PAD_LEFT);
            
            $monthlyBookings[] = Booking::whereYear('booking_date', $currentYear)
                ->whereMonth('booking_date', $month)
                ->count();

            $monthlyRevenue[] = Booking::whereYear('booking_date', $currentYear)
                ->whereMonth('booking_date', $month)
                ->where('status', 'completed')
                ->sum('total_amount');
        }

        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'bookings' => $monthlyBookings,
            'revenue' => $monthlyRevenue,
        ];
    }
}