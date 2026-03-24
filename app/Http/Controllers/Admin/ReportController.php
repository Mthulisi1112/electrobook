<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use App\Models\Electrician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Show reports page.
     */
    public function index(Request $request)
    {
        $type = $request->get('type', 'overview');
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        $data = match($type) {
            'bookings' => $this->getBookingReport($startDate, $endDate),
            'revenue' => $this->getRevenueReport($startDate, $endDate),
            'electricians' => $this->getElectricianReport($startDate, $endDate),
            'users' => $this->getUserReport($startDate, $endDate),
            default => $this->getOverviewReport($startDate, $endDate),
        };

        return view('admin.reports.index', compact('data', 'type', 'startDate', 'endDate'));
    }

    /**
     * Export report data.
     */
    public function export(Request $request, $type)
    {
        // Implementation for CSV/Excel export
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Generate export file
        // ...
    }

    /**
     * Show analytics page.
     */
    public function analytics()
    {
        $year = request('year', now()->year);

        $monthlyData = $this->getYearlyAnalytics($year);
        $growthData = $this->getGrowthMetrics();
        $topPerformers = $this->getTopPerformers();

        return view('admin.reports.analytics', compact(
            'year',
            'monthlyData',
            'growthData',
            'topPerformers'
        ));
    }

    private function getOverviewReport($startDate, $endDate)
    {
        return [
            'total_bookings' => Booking::whereBetween('created_at', [$startDate, $endDate])->count(),
            'completed_bookings' => Booking::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'completed')->count(),
            'total_revenue' => Booking::whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'completed')->sum('total_amount'),
            'new_users' => User::whereBetween('created_at', [$startDate, $endDate])->count(),
            'new_electricians' => Electrician::whereBetween('created_at', [$startDate, $endDate])->count(),
        ];
    }

    private function getBookingReport($startDate, $endDate)
    {
        return [
            'total' => Booking::whereBetween('booking_date', [$startDate, $endDate])->count(),
            'by_status' => Booking::whereBetween('booking_date', [$startDate, $endDate])
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get(),
            'by_service' => Booking::whereBetween('booking_date', [$startDate, $endDate])
                ->join('services', 'bookings.service_id', '=', 'services.id')
                ->select('services.name', DB::raw('count(*) as total'))
                ->groupBy('services.id', 'services.name')
                ->orderByDesc('total')
                ->get(),
        ];
    }

    private function getRevenueReport($startDate, $endDate)
    {
        return [
            'total' => Booking::whereBetween('booking_date', [$startDate, $endDate])
                ->where('status', 'completed')
                ->sum('total_amount'),
            'monthly' => Booking::whereBetween('booking_date', [$startDate, $endDate])
                ->where('status', 'completed')
                ->select(
                    DB::raw('strftime("%Y-%m", booking_date) as month'),
                    DB::raw('sum(total_amount) as total')
                )
                ->groupBy('month')
                ->orderBy('month')
                ->get(),
            'average' => Booking::whereBetween('booking_date', [$startDate, $endDate])
                ->where('status', 'completed')
                ->avg('total_amount') ?? 0,
        ];
    }

    private function getElectricianReport($startDate, $endDate)
    {
        return [
            'total' => Electrician::count(),
            'new' => Electrician::whereBetween('created_at', [$startDate, $endDate])->count(),
            'verified' => Electrician::where('is_verified', true)->count(),
            'top' => Electrician::with('user')
                ->withCount('bookings')
                ->withAvg('reviews', 'rating')
                ->orderBy('bookings_count', 'desc')
                ->limit(10)
                ->get(),
        ];
    }

    private function getUserReport($startDate, $endDate)
    {
        return [
            'total' => User::count(),
            'new' => User::whereBetween('created_at', [$startDate, $endDate])->count(),
            'by_role' => User::select('role', DB::raw('count(*) as total'))
                ->groupBy('role')
                ->get(),
        ];
    }

    private function getYearlyAnalytics($year)
    {
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = [
                'month' => date('F', mktime(0, 0, 0, $i, 1)),
                'bookings' => Booking::whereYear('booking_date', $year)
                    ->whereMonth('booking_date', $i)
                    ->count(),
                'revenue' => Booking::whereYear('booking_date', $year)
                    ->whereMonth('booking_date', $i)
                    ->where('status', 'completed')
                    ->sum('total_amount'),
                'users' => User::whereYear('created_at', $year)
                    ->whereMonth('created_at', $i)
                    ->count(),
            ];
        }
        return $months;
    }

    private function getGrowthMetrics()
    {
        $thisMonth = now()->startOfMonth();
        $lastMonth = now()->subMonth()->startOfMonth();

        return [
            'bookings_growth' => $this->calculateGrowth(
                Booking::whereMonth('booking_date', $lastMonth->month)->count(),
                Booking::whereMonth('booking_date', $thisMonth->month)->count()
            ),
            'revenue_growth' => $this->calculateGrowth(
                Booking::whereMonth('booking_date', $lastMonth->month)->where('status', 'completed')->sum('total_amount'),
                Booking::whereMonth('booking_date', $thisMonth->month)->where('status', 'completed')->sum('total_amount')
            ),
            'users_growth' => $this->calculateGrowth(
                User::whereMonth('created_at', $lastMonth->month)->count(),
                User::whereMonth('created_at', $thisMonth->month)->count()
            ),
        ];
    }

    private function calculateGrowth($previous, $current)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        return round((($current - $previous) / $previous) * 100, 1);
    }

    private function getTopPerformers()
    {
        return [
            'electricians' => Electrician::with('user')
                ->withCount('bookings')
                ->orderBy('bookings_count', 'desc')
                ->limit(5)
                ->get(),
            'services' => DB::table('bookings')
                ->join('services', 'bookings.service_id', '=', 'services.id')
                ->select('services.name', DB::raw('count(*) as total'))
                ->groupBy('services.id', 'services.name')
                ->orderByDesc('total')
                ->limit(5)
                ->get(),
        ];
    }
}