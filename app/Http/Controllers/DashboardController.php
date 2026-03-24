<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\Electrician;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the appropriate dashboard based on user role.
     */
    public function index()
    {
        $user = auth()->user();

        return match ($user->role) {
            'admin' => $this->adminDashboard(),
            'electrician' => $this->electricianDashboard($user),
            default => $this->clientDashboard($user),
        };
    }

    /**
     * Client dashboard.
     */
    private function clientDashboard(User $user)
    {
        $userId = $user->id;

        // Get statistics
        $totalBookings = Booking::where('client_id', $userId)->count();
        $completedBookings = Booking::where('client_id', $userId)
            ->where('status', 'completed')
            ->count();
        $pendingBookings = Booking::where('client_id', $userId)
            ->where('status', 'pending')
            ->count();
        $cancelledBookings = Booking::where('client_id', $userId)
            ->where('status', 'cancelled')
            ->count();
        
        $upcomingBookings = Booking::with(['electrician.user', 'service'])
            ->where('client_id', $userId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('booking_date', '>=', now())
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->get();

        $recentBookings = Booking::with(['electrician.user', 'service'])
            ->where('client_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $averageRating = Booking::where('client_id', $userId)
            ->whereHas('review')
            ->with('review')
            ->get()
            ->avg('review.rating') ?? 0;

        $reviewsCount = $user->reviews()->count();

        // Recent activity
        $recentActivity = $this->getClientRecentActivity($userId);

        // Chart data for last 6 months
        $chartData = $this->getClientChartData($userId);

        return view('dashboard.client', compact(
            'totalBookings',
            'completedBookings',
            'pendingBookings',
            'cancelledBookings',
            'upcomingBookings',
            'recentBookings',
            'averageRating',
            'reviewsCount',
            'recentActivity',
            'chartData'
        ));
    }

    /**
     * Electrician dashboard.
     */
    private function electricianDashboard(User $user)
    {
        $electrician = $user->electrician;

        if (!$electrician) {
            return redirect()->route('profile.edit')
                ->with('warning', 'Please complete your electrician profile first.');
        }

        // Get statistics
        $totalBookings = $electrician->bookings()->count();
        $completedBookings = $electrician->bookings()->where('status', 'completed')->count();
        $pendingBookings = $electrician->bookings()->where('status', 'pending')->count();
        $confirmedBookings = $electrician->bookings()->where('status', 'confirmed')->count();
        $cancelledBookings = $electrician->bookings()->where('status', 'cancelled')->count();
        
        $upcomingBookings = $electrician->bookings()
            ->with(['client', 'service'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('booking_date', '>=', now())
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->get();

        $pendingBookingsList = $electrician->bookings()
            ->with(['client', 'service'])
            ->where('status', 'pending')
            ->where('booking_date', '>=', now())
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->get();

        $recentBookings = $electrician->bookings()
            ->with(['client', 'service'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $totalEarnings = $electrician->bookings()
            ->where('status', 'completed')
            ->sum('total_amount');

        $monthlyEarnings = $electrician->bookings()
            ->where('status', 'completed')
            ->whereYear('booking_date', now()->year)
            ->sum('total_amount');

        $averageRating = $electrician->reviews()->avg('rating') ?? 0;
        $totalReviews = $electrician->reviews()->count();

        $availableSlots = $electrician->availabilitySlots()
            ->where('date', '>=', now())
            ->where('is_booked', false)
            ->count();

        $upcomingSlots = $electrician->availabilitySlots()
            ->where('date', '>=', now())
            ->where('is_booked', false)
            ->orderBy('date')
            ->orderBy('start_time')
            ->limit(5)
            ->get();

        // Chart data
        $chartData = $this->getElectricianChartData($electrician);

        return view('dashboard.electrician', compact(
            'totalBookings',
            'completedBookings',
            'pendingBookings',
            'confirmedBookings',
            'cancelledBookings',
            'upcomingBookings',
            'pendingBookingsList',
            'recentBookings',
            'totalEarnings',
            'monthlyEarnings',
            'averageRating',
            'totalReviews',
            'availableSlots',
            'upcomingSlots',
            'chartData'
        ));
    }

    /**
     * Admin dashboard.
     */
    private function adminDashboard()
    {
        $totalUsers = User::count();
        $totalElectricians = Electrician::count();
        $verifiedElectricians = Electrician::where('is_verified', true)->count();
        $pendingElectricians = Electrician::where('is_verified', false)->count();
        
        $totalBookings = Booking::count();
        $completedBookings = Booking::where('status', 'completed')->count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $cancelledBookings = Booking::where('status', 'cancelled')->count();
        
        $totalRevenue = Booking::where('status', 'completed')->sum('total_amount');
        
        $recentBookings = Booking::with(['client', 'electrician.user', 'service'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $bookingsByStatus = Booking::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $topElectricians = Electrician::with('user')
            ->withCount('bookings')
            ->withAvg('reviews', 'rating')
            ->orderBy('bookings_count', 'desc')
            ->limit(5)
            ->get();

        $recentUsers = User::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $monthlyStats = $this->getMonthlyStats();
        $recentReviews = Review::with(['client', 'electrician.user'])
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.admin', compact(
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
            'bookingsByStatus',
            'topElectricians',
            'recentUsers',
            'monthlyStats',
            'recentReviews'
        ));
    }

    /**
     * Get client's recent activity.
     */
    private function getClientRecentActivity($userId)
    {
        $bookings = Booking::where('client_id', $userId)
            ->with('service')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($booking) {
                return (object) [
                    'type' => 'booking',
                    'description' => "Booked {$booking->service->name}",
                    'status' => $booking->status,
                    'created_at' => $booking->created_at,
                ];
            });

        $reviews = Review::where('client_id', $userId)
            ->with('booking.service')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($review) {
                return (object) [
                    'type' => 'review',
                    'description' => "Reviewed {$review->booking->service->name}",
                    'rating' => $review->rating,
                    'created_at' => $review->created_at,
                ];
            });

        return $bookings->concat($reviews)
            ->sortByDesc('created_at')
            ->take(10)
            ->values();
    }

    /**
     * Get client chart data.
     */
    private function getClientChartData($userId)
    {
        $last6Months = [];
        $bookingCounts = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $last6Months[] = $month->format('M Y');
            
            $bookingCounts[] = Booking::where('client_id', $userId)
                ->whereYear('booking_date', $month->year)
                ->whereMonth('booking_date', $month->month)
                ->count();
        }

        return [
            'labels' => $last6Months,
            'bookings' => $bookingCounts,
        ];
    }

    /**
     * Get electrician chart data.
     */
    private function getElectricianChartData($electrician)
    {
        $last6Months = [];
        $bookingCounts = [];
        $earnings = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $last6Months[] = $month->format('M Y');
            
            $bookingCounts[] = $electrician->bookings()
                ->whereYear('booking_date', $month->year)
                ->whereMonth('booking_date', $month->month)
                ->count();

            $earnings[] = $electrician->bookings()
                ->where('status', 'completed')
                ->whereYear('booking_date', $month->year)
                ->whereMonth('booking_date', $month->month)
                ->sum('total_amount');
        }

        return [
            'labels' => $last6Months,
            'bookings' => $bookingCounts,
            'earnings' => $earnings,
        ];
    }

    /**
     * Get monthly statistics for admin.
     */
    private function getMonthlyStats()
    {
        $currentYear = now()->year;
        $months = [];

        for ($i = 1; $i <= 12; $i++) {
            $month = str_pad($i, 2, '0', STR_PAD_LEFT);
            
            $bookings = Booking::whereYear('booking_date', $currentYear)
                ->whereMonth('booking_date', $i)
                ->count();

            $revenue = Booking::whereYear('booking_date', $currentYear)
                ->whereMonth('booking_date', $i)
                ->where('status', 'completed')
                ->sum('total_amount');

            $months[] = [
                'month' => date('F', mktime(0, 0, 0, $i, 1)),
                'bookings' => $bookings,
                'revenue' => $revenue,
            ];
        }

        return $months;
    }

    /**
     * Show reports page (admin only).
     */
    public function reports(Request $request)
    {
        $this->authorize('viewReports', User::class);

        $year = $request->get('year', now()->year);
        $type = $request->get('type', 'monthly');

        $monthlyData = $this->getYearlyReport($year);
        $topElectricians = $this->getTopElectriciansReport();
        $userGrowth = $this->getUserGrowthReport();
        $popularServices = $this->getPopularServices();

        return view('admin.reports', compact(
            'year',
            'type',
            'monthlyData',
            'topElectricians',
            'userGrowth',
            'popularServices'
        ));
    }

    /**
     * Get yearly report data.
     */
    private function getYearlyReport($year)
    {
        $months = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $months[] = [
                'month' => date('F', mktime(0, 0, 0, $i, 1)),
                'bookings' => Booking::whereYear('booking_date', $year)
                    ->whereMonth('booking_date', $i)
                    ->count(),
                'completed' => Booking::whereYear('booking_date', $year)
                    ->whereMonth('booking_date', $i)
                    ->where('status', 'completed')
                    ->count(),
                'revenue' => Booking::whereYear('booking_date', $year)
                    ->whereMonth('booking_date', $i)
                    ->where('status', 'completed')
                    ->sum('total_amount'),
            ];
        }

        return $months;
    }

    /**
     * Get top electricians report.
     */
    private function getTopElectriciansReport()
    {
        return Electrician::with('user')
            ->withCount('bookings')
            ->withAvg('reviews', 'rating')
            ->orderBy('bookings_count', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Get user growth report.
     */
    private function getUserGrowthReport()
    {
        $sixMonthsAgo = now()->subMonths(6);

        $growth = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $growth[] = [
                'month' => $month->format('M Y'),
                'count' => User::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
            ];
        }

        return $growth;
    }

    /**
     * Get popular services.
     */
    private function getPopularServices()
    {
        return DB::table('bookings')
            ->join('services', 'bookings.service_id', '=', 'services.id')
            ->select('services.name', DB::raw('count(*) as total'))
            ->groupBy('services.id', 'services.name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
    }
}