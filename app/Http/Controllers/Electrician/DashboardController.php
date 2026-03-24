<?php

namespace App\Http\Controllers\Electrician;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Log that we're here
        Log::info('=== ELECTRICIAN DASHBOARD CONTROLLER HIT ===');
        
        $user = Auth::user();
        Log::info('User ID: ' . $user->id . ', Role: ' . $user->role);
        
        // Ensure user is actually an electrician
        if (!$user->isElectrician()) {
            Log::warning('User attempting to access electrician dashboard but is not an electrician: ' . $user->id);
            abort(403, 'Unauthorized access. This area is for electricians only.');
        }
        
        $electrician = $user->electrician;
        
        if (!$electrician) {
            Log::warning('No electrician profile found for user: ' . $user->id);
            return redirect()->route('profile.edit')
                ->with('warning', 'Please complete your electrician profile first.');
        }
        
        Log::info('Electrician ID: ' . $electrician->id);

        // Verify the electrician belongs to the logged-in user
        // (This is redundant but adds an extra layer of security)
        if ($electrician->user_id !== $user->id) {
            Log::error('SECURITY: Electrician profile user_id mismatch! User: ' . $user->id . ', Electrician user_id: ' . $electrician->user_id);
            abort(403, 'Unauthorized access.');
        }

        // Get statistics - ALL filtered by this electrician automatically
        $stats = [
            'total_bookings' => $electrician->bookings()->count(),
            'completed_bookings' => $electrician->bookings()->where('status', 'completed')->count(),
            'pending_bookings' => $electrician->bookings()->where('status', 'pending')->count(),
            'confirmed_bookings' => $electrician->bookings()->where('status', 'confirmed')->count(),
            'cancelled_bookings' => $electrician->bookings()->where('status', 'cancelled')->count(),
            'total_earnings' => $electrician->bookings()->where('status', 'completed')->sum('total_amount'),
            'average_rating' => $electrician->reviews()->avg('rating') ?? 0,
            'total_reviews' => $electrician->reviews()->count(),
            'available_slots' => $electrician->availabilitySlots()
                ->where('is_booked', false)
                ->where('date', '>=', now())
                ->count(),
        ];
        
        Log::info('Stats calculated:', $stats);

        // Get upcoming bookings - ONLY this electrician's bookings
        $upcoming_bookings = $electrician->bookings()
            ->with(['client', 'service'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('booking_date', '>=', now())
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->limit(5)
            ->get();
        
        Log::info('Upcoming bookings count: ' . $upcoming_bookings->count());

        // Get recent bookings - ONLY this electrician's bookings
        $recent_bookings = $electrician->bookings()
            ->with(['client', 'service'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        Log::info('Recent bookings count: ' . $recent_bookings->count());

        // Get chart data - ONLY this electrician's data
        $chart_data = $this->getChartData($electrician);
        
        Log::info('Chart data prepared');

        // Return view with ALL variables
        Log::info('Returning view with variables: stats, upcoming_bookings, recent_bookings, chart_data');
        
        return view('dashboard.electrician', [
            'stats' => $stats,
            'upcoming_bookings' => $upcoming_bookings,
            'recent_bookings' => $recent_bookings,
            'chart_data' => $chart_data
        ]);
    }

    private function getChartData($electrician)
    {
        // Ensure only this electrician's data is used
        $last6Months = [];
        $bookingCounts = [];
        $earnings = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $last6Months[] = $month->format('M Y');
            
            // All queries use the passed $electrician parameter
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
     * Display the earnings page with detailed financial information
     */
    public function earnings()
    {
        $user = Auth::user();
        $electrician = $user->electrician;
        
        if (!$electrician) {
            return redirect()->route('profile.edit')
                ->with('warning', 'Please complete your electrician profile first.');
        }

        // Get current year and month for filtering
        $currentYear = request('year', Carbon::now()->year);
        $currentMonth = request('month', Carbon::now()->month);

        // Total earnings all time (completed bookings only)
        $totalEarnings = $electrician->bookings()
            ->where('status', 'completed')
            ->sum('total_amount');

        // Earnings this month
        $monthlyEarnings = $electrician->bookings()
            ->where('status', 'completed')
            ->whereYear('booking_date', $currentYear)
            ->whereMonth('booking_date', $currentMonth)
            ->sum('total_amount');

        // Earnings this year
        $yearlyEarnings = $electrician->bookings()
            ->where('status', 'completed')
            ->whereYear('booking_date', $currentYear)
            ->sum('total_amount');

        // Count completed bookings
        $completedBookings = $electrician->bookings()
            ->where('status', 'completed')
            ->count();
        
        // Average earnings per booking
        $averagePerBooking = $completedBookings > 0 
            ? $totalEarnings / $completedBookings 
            : 0;

        // Monthly earnings for chart (last 12 months)
        $monthlyChartData = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyChartData[] = [
                'month' => $date->format('M Y'),
                'earnings' => $electrician->bookings()
                    ->where('status', 'completed')
                    ->whereYear('booking_date', $date->year)
                    ->whereMonth('booking_date', $date->month)
                    ->sum('total_amount'),
                'bookings' => $electrician->bookings()
                    ->where('status', 'completed')
                    ->whereYear('booking_date', $date->year)
                    ->whereMonth('booking_date', $date->month)
                    ->count()
            ];
        }

        // Recent earnings transactions
        $recentEarnings = $electrician->bookings()
            ->with(['client', 'service'])
            ->where('status', 'completed')
            ->orderBy('booking_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // ✅ FIXED: Payment methods breakdown (now works with new column)
        $paymentMethods = $electrician->bookings()
            ->where('status', 'completed')
            ->selectRaw('payment_method, count(*) as count, sum(total_amount) as total')
            ->whereNotNull('payment_method')
            ->groupBy('payment_method')
            ->get();

        // Upcoming expected payments (pending/confirmed bookings)
        $pendingPayments = $electrician->bookings()
            ->with(['client', 'service'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('booking_date', '>=', now())
            ->orderBy('booking_date', 'asc')
            ->limit(5)
            ->get();

        // Earnings by status breakdown
        $earningsByStatus = [
            'completed' => $electrician->bookings()->where('status', 'completed')->sum('total_amount'),
            'confirmed' => $electrician->bookings()->where('status', 'confirmed')->sum('total_amount'),
            'pending' => $electrician->bookings()->where('status', 'pending')->sum('total_amount'),
            'cancelled' => $electrician->bookings()->where('status', 'cancelled')->sum('total_amount'),
        ];

        // Count by status
        $bookingsByStatus = [
            'completed' => $electrician->bookings()->where('status', 'completed')->count(),
            'confirmed' => $electrician->bookings()->where('status', 'confirmed')->count(),
            'pending' => $electrician->bookings()->where('status', 'pending')->count(),
            'cancelled' => $electrician->bookings()->where('status', 'cancelled')->count(),
        ];

        // Payment status breakdown
        $paymentStatusBreakdown = [
            'paid' => $electrician->bookings()->where('payment_status', 'paid')->sum('total_amount'),
            'pending' => $electrician->bookings()->where('payment_status', 'pending')->sum('total_amount'),
        ];

        // Monthly comparison (this month vs last month)
        $lastMonth = Carbon::now()->subMonth();
        $lastMonthEarnings = $electrician->bookings()
            ->where('status', 'completed')
            ->whereYear('booking_date', $lastMonth->year)
            ->whereMonth('booking_date', $lastMonth->month)
            ->sum('total_amount');
        
        $earningsGrowth = $lastMonthEarnings > 0 
            ? (($monthlyEarnings - $lastMonthEarnings) / $lastMonthEarnings) * 100 
            : 0;

        // Top earning services
        $topServices = $electrician->bookings()
            ->with('service')
            ->where('status', 'completed')
            ->selectRaw('service_id, count(*) as total_bookings, sum(total_amount) as total_earnings')
            ->groupBy('service_id')
            ->orderBy('total_earnings', 'desc')
            ->limit(5)
            ->get();

        return view('electrician.earnings', compact(
            'totalEarnings',
            'monthlyEarnings',
            'yearlyEarnings',
            'averagePerBooking',
            'completedBookings',
            'monthlyChartData',
            'recentEarnings',
            'paymentMethods', 
            'pendingPayments',
            'earningsByStatus',
            'bookingsByStatus',
            'paymentStatusBreakdown',
            'earningsGrowth',
            'currentYear',
            'currentMonth',
            'topServices'
        ));
    }
        /**
     * Display the reviews page with all ratings and feedback
     */
    public function reviews()
    {
        $user = Auth::user();
        $electrician = $user->electrician;
        
        if (!$electrician) {
            return redirect()->route('profile.edit')
                ->with('warning', 'Please complete your electrician profile first.');
        }

        // Get all reviews for this electrician with pagination
        $reviews = $electrician->reviews()
            ->with(['booking.client', 'booking.service'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculate rating statistics
        $totalReviews = $electrician->reviews()->count();
        $averageRating = $electrician->reviews()->avg('rating') ?? 0;
        
        // Count reviews by star rating
        $rating_stats = [
            'average' => $averageRating,
            'total' => $totalReviews,
            '5_star' => $electrician->reviews()->where('rating', 5)->count(),
            '4_star' => $electrician->reviews()->where('rating', 4)->count(),
            '3_star' => $electrician->reviews()->where('rating', 3)->count(),
            '2_star' => $electrician->reviews()->where('rating', 2)->count(),
            '1_star' => $electrician->reviews()->where('rating', 1)->count(),
        ];

        return view('electrician.reviews', compact('reviews', 'rating_stats'));
    }
}