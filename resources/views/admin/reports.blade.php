@extends('layouts.app')

@section('title', 'Reports & Analytics')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <x-admin.report-header 
        title="Reports & Analytics" 
        subtitle="Comprehensive platform performance reports and insights"
    />

    <!-- Year Selector and Actions -->
    <div class="flex justify-between items-center mb-6">
        <x-admin.year-selector :selectedYear="$year" route="{{ route('admin.reports') }}" />
        <x-admin.export-buttons :year="$year" :type="$type" />
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        @php
            $totalBookings = collect($monthlyData)->sum('bookings');
            $totalRevenue = collect($monthlyData)->sum('revenue');
            $totalCompleted = collect($monthlyData)->sum('completed');
            $avgCompletionRate = $totalBookings > 0 ? round(($totalCompleted / $totalBookings) * 100, 1) : 0;
        @endphp

        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-500 mb-1">Total Bookings ({{ $year }})</p>
            <p class="text-3xl font-bold text-[#1e3a5f]">{{ $totalBookings }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-500 mb-1">Total Revenue</p>
            <p class="text-3xl font-bold text-green-600">${{ number_format($totalRevenue, 2) }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-500 mb-1">Completed Jobs</p>
            <p class="text-3xl font-bold text-blue-600">{{ $totalCompleted }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-500 mb-1">Completion Rate</p>
            <p class="text-3xl font-bold text-purple-600">{{ $avgCompletionRate }}%</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Monthly Stats Table - Spans 2 columns -->
        <div class="lg:col-span-2">
            <x-admin.monthly-stats-table :monthlyData="$monthlyData" :year="$year" />
        </div>

        <!-- Sidebar - Spans 1 column -->
        <div class="lg:col-span-1 space-y-8">
            <!-- User Growth -->
            <x-admin.user-growth-chart :growth="$userGrowth" />

            <!-- Popular Services -->
            <x-admin.popular-services-card :services="$popularServices" />

            <!-- Quick Stats -->
            <div class="bg-gradient-to-br from-[#1e3a5f] to-[#2d4a7c] text-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Quick Insights</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span>Average Booking Value</span>
                        <span class="font-bold">${{ $totalBookings > 0 ? number_format($totalRevenue / $totalBookings, 2) : 0 }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Best Month</span>
                        <span class="font-bold">
                            @php
                                $bestMonth = collect($monthlyData)->sortByDesc('bookings')->first();
                            @endphp
                            {{ $bestMonth ? $bestMonth['month'] : 'N/A' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span>Peak Revenue</span>
                        <span class="font-bold">
                            ${{ $bestMonth ? number_format($bestMonth['revenue'], 2) : 0 }}
                        </span>
                    </div>
                    <div class="pt-3 border-t border-blue-400">
                        <div class="flex justify-between">
                            <span>Platform Health</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-500 text-white">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Active
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Electricians Table - Full Width -->
    <div class="mt-8">
        <x-admin.top-electricians-table :electricians="$topElectricians" />
    </div>

    <!-- Year-over-Year Comparison -->
    <div class="mt-8 bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Year-over-Year Comparison</h2>
        
        @php
            $previousYear = $year - 1;
            $previousYearData = collect($monthlyData);
            $currentYearTotal = $totalBookings;
            $previousYearTotal = Booking::whereYear('booking_date', $previousYear)->count();
            $growthPercentage = $previousYearTotal > 0 ? round((($currentYearTotal - $previousYearTotal) / $previousYearTotal) * 100, 1) : 0;
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-500 mb-1">{{ $year }} Bookings</p>
                <p class="text-2xl font-bold text-[#1e3a5f]">{{ $currentYearTotal }}</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-500 mb-1">{{ $previousYear }} Bookings</p>
                <p class="text-2xl font-bold text-gray-600">{{ $previousYearTotal }}</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-500 mb-1">Growth</p>
                <p class="text-2xl font-bold {{ $growthPercentage >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $growthPercentage >= 0 ? '+' : '' }}{{ $growthPercentage }}%
                </p>
            </div>
        </div>

        <!-- Growth Indicator -->
        <div class="mt-4 flex items-center justify-center">
            <div class="w-full max-w-md bg-gray-200 rounded-full h-3">
                <div class="h-3 rounded-full {{ $growthPercentage >= 0 ? 'bg-green-500' : 'bg-red-500' }}" 
                     style="width: {{ min(abs($growthPercentage), 100) }}%">
                </div>
            </div>
        </div>
    </div>

    <!-- Report Generation Info -->
    <div class="mt-8 bg-blue-50 rounded-lg p-6">
        <div class="flex items-start">
            <div class="shrink-0">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">About these reports</h3>
                <p class="text-sm text-blue-700 mt-1">
                    Reports are generated based on booking data and user activity. 
                    Use the year selector to view historical data, and export options to download reports for your records.
                </p>
                <div class="mt-3 flex space-x-4">
                    <span class="inline-flex items-center text-xs text-blue-600">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Updated in real-time
                    </span>
                    <span class="inline-flex items-center text-xs text-blue-600">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Secure data
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection