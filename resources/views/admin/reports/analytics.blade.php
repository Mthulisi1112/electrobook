@extends('layouts.app')

@section('title', 'Analytics Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#1e3a5f]">Analytics Dashboard</h1>
            <p class="text-gray-600 mt-2">Deep insights into platform performance</p>
        </div>
        <div class="flex space-x-3">
            <select onchange="window.location.href = '{{ route('admin.reports.analytics') }}?year=' + this.value" 
                    class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-[#3b82f6] focus:border-[#3b82f6]">
                @for($y = now()->year; $y >= now()->year - 3; $y--)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <a href="{{ route('admin.reports') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Reports
            </a>
        </div>
    </div>

    <!-- Growth Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Bookings Growth</p>
                    <p class="text-2xl font-bold {{ $growthData['bookings_growth'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $growthData['bookings_growth'] }}%
                    </p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">vs previous month</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Revenue Growth</p>
                    <p class="text-2xl font-bold {{ $growthData['revenue_growth'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $growthData['revenue_growth'] }}%
                    </p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">vs previous month</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">User Growth</p>
                    <p class="text-2xl font-bold {{ $growthData['users_growth'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $growthData['users_growth'] }}%
                    </p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">vs previous month</p>
        </div>
    </div>

    <!-- Monthly Data Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-[#1e3a5f]">Monthly Performance - {{ $year }}</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Month</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bookings</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">New Users</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($monthlyData as $month)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $month['month'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $month['bookings'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($month['revenue'], 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $month['users'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td class="px-6 py-3 text-sm font-semibold text-gray-900">Total</td>
                        <td class="px-6 py-3 text-sm font-semibold text-gray-900">{{ collect($monthlyData)->sum('bookings') }}</td>
                        <td class="px-6 py-3 text-sm font-semibold text-gray-900">${{ number_format(collect($monthlyData)->sum('revenue'), 2) }}</td>
                        <td class="px-6 py-3 text-sm font-semibold text-gray-900">{{ collect($monthlyData)->sum('users') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Top Performers -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Top Electricians -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-[#1e3a5f]">Top Electricians</h2>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($topPerformers['electricians'] as $index => $electrician)
                    <div class="p-4 hover:bg-gray-50">
                        <div class="flex items-center">
                            <div class="shrink-0 w-8 text-lg font-bold text-gray-400">#{{ $index + 1 }}</div>
                            <div class="shrink-0 ml-2">
                                <div class="h-10 w-10 rounded-full bg-[#1e3a5f] flex items-center justify-center text-white font-bold">
                                    {{ substr($electrician->business_name, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $electrician->business_name }}</p>
                                <p class="text-xs text-gray-500">{{ $electrician->bookings_count }} bookings</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Popular Services -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-[#1e3a5f]">Popular Services</h2>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($topPerformers['services'] as $index => $service)
                    <div class="p-4 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="w-8 text-lg font-bold text-gray-400">#{{ $index + 1 }}</span>
                                <span class="ml-2 text-sm font-medium text-gray-900">{{ $service->name }}</span>
                            </div>
                            <span class="text-sm font-semibold text-[#3b82f6]">{{ $service->total }} bookings</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection