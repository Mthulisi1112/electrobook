@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#1e3a5f]">Reports & Analytics</h1>
            <p class="text-gray-600 mt-2">Generate and view platform reports</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.reports.analytics') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#3b82f6] hover:bg-[#2563eb]">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                View Analytics
            </a>
            <x-admin.export-buttons :type="$type" :startDate="$startDate" :endDate="$endDate" />
        </div>
    </div>

    <!-- Date Range and Type Filters -->
    <x-admin.report-filters :type="$type" :startDate="$startDate" :endDate="$endDate" />

    <!-- Report Content -->
    <div class="mt-8">
        @switch($type)
            @case('bookings')
                <x-admin.bookings-report :data="$data" />
                @break
            @case('revenue')
                <x-admin.revenue-report :data="$data" />
                @break
            @case('electricians')
                <x-admin.electricians-report :data="$data" />
                @break
            @case('users')
                <x-admin.users-report :data="$data" />
                @break
            @default
                <x-admin.overview-report :data="$data" />
        @endswitch
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.reports', ['type' => 'overview', 'start_date' => now()->startOfMonth()->format('Y-m-d'), 'end_date' => now()->endOfMonth()->format('Y-m-d')]) }}" 
           class="bg-white p-4 rounded-lg shadow hover:shadow-md transition flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg mr-3">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-gray-900">This Month</p>
                <p class="text-sm text-gray-500">Quick overview</p>
            </div>
        </a>

        <a href="{{ route('admin.reports', ['type' => 'bookings', 'start_date' => now()->startOfQuarter()->format('Y-m-d'), 'end_date' => now()->endOfQuarter()->format('Y-m-d')]) }}" 
           class="bg-white p-4 rounded-lg shadow hover:shadow-md transition flex items-center">
            <div class="p-2 bg-green-100 rounded-lg mr-3">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-gray-900">This Quarter</p>
                <p class="text-sm text-gray-500">Bookings report</p>
            </div>
        </a>

        <a href="{{ route('admin.reports', ['type' => 'revenue', 'start_date' => now()->startOfYear()->format('Y-m-d'), 'end_date' => now()->endOfYear()->format('Y-m-d')]) }}" 
           class="bg-white p-4 rounded-lg shadow hover:shadow-md transition flex items-center">
            <div class="p-2 bg-purple-100 rounded-lg mr-3">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-gray-900">This Year</p>
                <p class="text-sm text-gray-500">Revenue report</p>
            </div>
        </a>

        <a href="{{ route('admin.reports.analytics') }}" 
           class="bg-white p-4 rounded-lg shadow hover:shadow-md transition flex items-center">
            <div class="p-2 bg-amber-100 rounded-lg mr-3">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-gray-900">Analytics</p>
                <p class="text-sm text-gray-500">Detailed insights</p>
            </div>
        </a>
    </div>
</div>
@endsection