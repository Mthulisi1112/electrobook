@extends('layouts.app')

@section('title', 'Electrician Dashboard')

@push('styles')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    <!-- Header with Glass Effect -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#1e3a5f] via-[#2b4c7c] to-[#3b82f6] p-8 text-white shadow-2xl">
        <!-- Decorative Elements -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-20 -mt-20 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-blue-400/20 rounded-full -ml-16 -mb-16 blur-2xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-4xl font-bold tracking-tight mb-2">
                    Welcome back, {{ auth()->user()->name }}!
                </h1>
                <p class="text-blue-100 text-lg">
                    {{ now()->format('l, F j, Y') }} • Here's your business overview
                </p>
            </div>
            <div class="mt-6 md:mt-0 flex items-center gap-4">
                <div class="bg-white/10 backdrop-blur-md px-5 py-3 rounded-2xl border border-white/20 hover:bg-white/20 transition cursor-pointer" onclick="window.location='{{ route('electrician.earnings') }}'">
                    <p class="text-xs text-blue-200 mb-1">Total Earnings</p>
                    <p class="text-3xl font-bold">${{ number_format($stats['total_earnings'] ?? 0) }}</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md px-5 py-3 rounded-2xl border border-white/20 hover:bg-white/20 transition cursor-pointer" onclick="window.location='{{ route('electrician.reviews') }}'">
                    <p class="text-xs text-blue-200 mb-1">Rating</p>
                    <div class="flex items-center">
                        <p class="text-3xl font-bold mr-2">{{ number_format($stats['average_rating'] ?? 0, 1) }}</p>
                        <div class="flex text-amber-300">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($stats['average_rating'] ?? 0))
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">★</svg>
                                @else
                                    <svg class="w-4 h-4 text-white/40" viewBox="0 0 20 20">★</svg>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6">
        <!-- Total Bookings Card -->
        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 p-6 hover:border-blue-200 hover-lift">
            <div class="flex items-start justify-between mb-4">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-3 rounded-xl group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">↑ 12%</span>
            </div>
            <p class="text-sm text-gray-500 mb-1">Total Bookings</p>
            <p class="text-3xl font-bold text-[#1e3a5f]">{{ $stats['total_bookings'] ?? 0 }}</p>
        </div>

        <!-- Completed Card -->
        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 p-6 hover:border-emerald-200 hover-lift">
            <div class="flex items-start justify-between mb-4">
                <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 p-3 rounded-xl group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-500">{{ $stats['total_bookings'] > 0 ? round(($stats['completed_bookings'] / $stats['total_bookings']) * 100) : 0 }}%</span>
            </div>
            <p class="text-sm text-gray-500 mb-1">Completed</p>
            <p class="text-3xl font-bold text-[#1e3a5f]">{{ $stats['completed_bookings'] ?? 0 }}</p>
        </div>

        <!-- Pending Card -->
        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 p-6 hover:border-amber-200 hover-lift">
            <div class="flex items-start justify-between mb-4">
                <div class="bg-gradient-to-br from-amber-50 to-amber-100 p-3 rounded-xl group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-amber-600 bg-amber-50 px-2 py-1 rounded-full">Action needed</span>
            </div>
            <p class="text-sm text-gray-500 mb-1">Pending</p>
            <p class="text-3xl font-bold text-amber-500">{{ $stats['pending_bookings'] ?? 0 }}</p>
        </div>

        <!-- Earnings Card -->
        <a href="{{ route('electrician.earnings') }}" class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 p-6 hover:border-purple-200 hover-lift block">
            <div class="flex items-start justify-between mb-4">
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-3 rounded-xl group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-purple-600 bg-purple-50 px-2 py-1 rounded-full group-hover:bg-purple-100 transition">
                    Details →
                </span>
            </div>
            <p class="text-sm text-gray-500 mb-1">Total Earnings</p>
            <p class="text-3xl font-bold text-[#1e3a5f]">${{ number_format($stats['total_earnings'] ?? 0) }}</p>
            <p class="text-xs text-gray-400 mt-2">{{ $stats['completed_bookings'] ?? 0 }} completed jobs</p>
        </a>

        <!-- Reviews Card -->
        <a href="{{ route('electrician.reviews') }}" class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 p-6 hover:border-amber-200 hover-lift block">
            <div class="flex items-start justify-between mb-4">
                <div class="bg-gradient-to-br from-amber-50 to-amber-100 p-3 rounded-xl group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-amber-600 bg-amber-50 px-2 py-1 rounded-full group-hover:bg-amber-100 transition">
                    {{ $stats['total_reviews'] ?? 0 }} reviews
                </span>
            </div>
            <p class="text-sm text-gray-500 mb-1">Average Rating</p>
            <div class="flex items-baseline">
                <p class="text-3xl font-bold text-[#1e3a5f] mr-2">{{ number_format($stats['average_rating'] ?? 0, 1) }}</p>
                <div class="flex text-amber-400">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($stats['average_rating'] ?? 0))
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">★</svg>
                        @else
                            <svg class="w-4 h-4 text-gray-300" viewBox="0 0 20 20">★</svg>
                        @endif
                    @endfor
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-2">Click to view all reviews</p>
        </a>

        <!-- Cancelled Card (New) -->
        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 p-6 hover:border-red-200 hover-lift">
            <div class="flex items-start justify-between mb-4">
                <div class="bg-gradient-to-br from-red-50 to-red-100 p-3 rounded-xl group-hover:scale-110 transition-transform">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-500">{{ $stats['total_bookings'] > 0 ? round(($stats['cancelled_bookings'] / $stats['total_bookings']) * 100) : 0 }}%</span>
            </div>
            <p class="text-sm text-gray-500 mb-1">Cancelled</p>
            <p class="text-3xl font-bold text-red-500">{{ $stats['cancelled_bookings'] ?? 0 }}</p>
        </div>
    </div>

    <!-- Today's Schedule Widget -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-[#1e3a5f] flex items-center">
                <svg class="w-5 h-5 mr-2 text-[#3b82f6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Today's Schedule • {{ now()->format('l, F j, Y') }}
            </h3>
            <span class="text-sm text-gray-600">{{ now()->format('g:i A') }}</span>
        </div>
        
        @php
            $todaysBookings = isset($upcoming_bookings) ? $upcoming_bookings->filter(function($booking) {
                return isset($booking->booking_date) && \Carbon\Carbon::parse($booking->booking_date)->isToday();
            }) : collect();
        @endphp
        
        @if($todaysBookings->isNotEmpty())
            <div class="space-y-3">
                @foreach($todaysBookings as $booking)
                    <div class="flex items-center p-3 bg-white rounded-xl shadow-sm">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-[#1e3a5f] to-[#3b82f6] flex items-center justify-center text-white font-bold text-lg mr-3">
                            {{ substr($booking->start_time ?? '9', 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <h4 class="font-medium text-gray-900">{{ $booking->client->name ?? 'Client' }}</h4>
                                <span class="text-sm font-semibold text-[#3b82f6]">{{ isset($booking->start_time) ? \Carbon\Carbon::parse($booking->start_time)->format('g:i A') : 'TBD' }}</span>
                            </div>
                            <p class="text-sm text-gray-600">{{ $booking->service->name ?? 'Service' }}</p>
                            <p class="text-xs text-gray-500">{{ $booking->address ?? 'Address TBD' }}</p>
                        </div>
                        <a href="{{ route('electrician.bookings.show', $booking) }}" 
                           class="ml-3 p-2 text-gray-400 hover:text-[#3b82f6] transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl p-8 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12z"/>
                    </svg>
                </div>
                <p class="text-gray-600 font-medium">No appointments scheduled for today</p>
                <p class="text-sm text-gray-400 mt-1">Enjoy your day off or add more availability</p>
            </div>
        @endif
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Performance Chart Card -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-semibold text-[#1e3a5f] text-lg">Performance Analytics</h3>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                        <span class="text-xs text-gray-600">Bookings</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-emerald-500 rounded-full mr-2"></span>
                        <span class="text-xs text-gray-600">Earnings ($)</span>
                    </div>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="performanceChart"></canvas>
            </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-semibold text-[#1e3a5f] text-lg mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('electrician.availability.create') }}" 
                   class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-blue-100/50 rounded-xl hover:from-blue-100 hover:to-blue-200 transition group hover-lift">
                    <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center mr-3 group-hover:scale-110 transition">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Add Availability</p>
                        <p class="text-xs text-gray-500">Create new time slots</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>

                <a href="{{ route('electrician.bookings.index', ['status' => 'pending']) }}" 
                   class="flex items-center p-4 bg-gradient-to-r from-amber-50 to-amber-100/50 rounded-xl hover:from-amber-100 hover:to-amber-200 transition group hover-lift">
                    <div class="w-10 h-10 bg-amber-500 rounded-xl flex items-center justify-center mr-3 group-hover:scale-110 transition">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Review Pending</p>
                        <p class="text-xs text-gray-500">{{ $stats['pending_bookings'] ?? 0 }} need attention</p>
                    </div>
                    <span class="px-2 py-1 bg-amber-500 text-white text-xs rounded-full">{{ $stats['pending_bookings'] ?? 0 }}</span>
                </a>

                <a href="{{ route('electrician.availability.index') }}" 
                   class="flex items-center p-4 bg-gradient-to-r from-purple-50 to-purple-100/50 rounded-xl hover:from-purple-100 hover:to-purple-200 transition group hover-lift">
                    <div class="w-10 h-10 bg-purple-500 rounded-xl flex items-center justify-center mr-3 group-hover:scale-110 transition">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Manage Schedule</p>
                        <p class="text-xs text-gray-500">View and edit your slots</p>
                    </div>
                </a>

                <a href="{{ route('electrician.earnings') }}" 
                   class="flex items-center p-4 bg-gradient-to-r from-purple-50 to-purple-100/50 rounded-xl hover:from-purple-100 hover:to-purple-200 transition group hover-lift">
                    <div class="w-10 h-10 bg-purple-500 rounded-xl flex items-center justify-center mr-3 group-hover:scale-110 transition">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Earnings Report</p>
                        <p class="text-xs text-gray-500">View your income and analytics</p>
                    </div>
                    <span class="px-2 py-1 bg-purple-500 text-white text-xs rounded-full">${{ number_format($stats['total_earnings'] ?? 0) }}</span>
                </a>

                <a href="{{ route('electrician.reviews') }}" 
                   class="flex items-center p-4 bg-gradient-to-r from-amber-50 to-amber-100/50 rounded-xl hover:from-amber-100 hover:to-amber-200 transition group hover-lift">
                    <div class="w-10 h-10 bg-amber-500 rounded-xl flex items-center justify-center mr-3 group-hover:scale-110 transition">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Reviews</p>
                        <p class="text-xs text-gray-500">See what clients are saying</p>
                    </div>
                    <div class="flex items-center">
                        <span class="text-amber-500 font-bold mr-1">{{ number_format($stats['average_rating'] ?? 0, 1) }}</span>
                        <svg class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20">★</svg>
                    </div>
                </a>

                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center p-4 bg-gradient-to-r from-gray-50 to-gray-100/50 rounded-xl hover:from-gray-100 hover:to-gray-200 transition group hover-lift">
                    <div class="w-10 h-10 bg-gray-600 rounded-xl flex items-center justify-center mr-3 group-hover:scale-110 transition">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Edit Profile</p>
                        <p class="text-xs text-gray-500">Update your information</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Bookings Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Upcoming Bookings -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover-lift">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-[#1e3a5f] flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#3b82f6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12z"/>
                        </svg>
                        Upcoming Bookings
                    </h3>
                    <span class="text-xs text-gray-500">Next 7 days</span>
                </div>
            </div>
            
            <div class="p-6">
                @if($upcoming_bookings->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($upcoming_bookings as $booking)
                            <div class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition group">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#1e3a5f] to-[#3b82f6] flex items-center justify-center text-white font-bold text-sm mr-3">
                                    {{ substr($booking->client->name ?? 'C', 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="font-medium text-gray-900">{{ $booking->client->name ?? 'Client' }}</span>
                                        <span class="text-xs px-2 py-0.5 rounded-full 
                                            @if($booking->status == 'confirmed') bg-green-100 text-green-700
                                            @elseif($booking->status == 'pending') bg-amber-100 text-amber-700
                                            @elseif($booking->status == 'completed') bg-blue-100 text-blue-700
                                            @else bg-gray-100 text-gray-700 @endif">
                                            {{ ucfirst($booking->status ?? 'pending') }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-600 mb-1">{{ $booking->service->name ?? 'Service' }}</p>
                                    <div class="flex items-center text-xs text-gray-500">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12z"/>
                                        </svg>
                                        {{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('M j, Y g:i A') : 'TBD' }}
                                    </div>
                                </div>
                                <a href="{{ route('electrician.bookings.show', $booking) }}" 
                                class="ml-2 p-2 text-gray-400 hover:text-[#3b82f6] transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('electrician.bookings.index') }}" class="text-sm text-[#3b82f6] hover:text-[#2563eb] font-medium inline-flex items-center">
                            View all bookings
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500">No upcoming bookings</p>
                        <p class="text-xs text-gray-400 mt-1">Your schedule will appear here</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover-lift">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
                <h3 class="font-semibold text-[#1e3a5f] flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#3b82f6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Recent Bookings
                </h3>
                <a href="{{ route('electrician.bookings.index') }}" class="text-xs text-[#3b82f6] hover:text-[#2563eb] font-medium">
                    View All
                </a>
            </div>
            
            <div class="p-6">
                @if($recent_bookings->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($recent_bookings as $booking)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#1e3a5f] to-[#3b82f6] flex items-center justify-center text-white font-bold text-sm">
                                        {{ substr($booking->client->name ?? 'C', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $booking->client->name ?? 'Client' }}</p>
                                        <p class="text-xs text-gray-500">{{ $booking->service->name ?? 'Service' }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-[#3b82f6]">${{ number_format($booking->total_amount ?? 0, 2) }}</p>
                                    <p class="text-xs text-gray-500">{{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('M j, Y') : '' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <p class="text-gray-500">No recent bookings</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Insights & Tips -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100 hover-lift">
            <div class="flex items-start">
                <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center mr-4">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-[#1e3a5f] mb-1">Business Insight</h4>
                    <p class="text-sm text-gray-600">
                        @if(($stats['pending_bookings'] ?? 0) > 0)
                            You have <span class="font-semibold text-amber-600">{{ $stats['pending_bookings'] }}</span> pending bookings. 
                            Respond quickly to maintain your response rate.
                        @elseif(($stats['available_slots'] ?? 0) < 5)
                            Only {{ $stats['available_slots'] }} slots available. Adding more could increase bookings by 30%.
                        @else
                            Your business is performing well! You're in the top 15% of electricians.
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-6 border border-purple-100 hover-lift">
            <div class="flex items-start">
                <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center mr-4">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-[#1e3a5f] mb-1">Pro Tip</h4>
                    <p class="text-sm text-gray-600">
                        @if(($stats['average_rating'] ?? 0) >= 4.5)
                            ⭐ Excellent! Electricians with 5-star ratings get 3x more bookings.
                        @elseif(($stats['average_rating'] ?? 0) >= 4)
                            👍 Good rating! Respond to all reviews to build trust.
                        @else
                            📝 Focus on collecting reviews. Each review increases booking chances by 15%.
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('performanceChart').getContext('2d');
    
    // Prepare data safely with fallbacks
    const labels = {!! json_encode($chart_data['labels'] ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!};
    const bookingsData = {!! json_encode($chart_data['bookings'] ?? [5, 8, 12, 7, 10, 15]) !!};
    const earningsData = {!! json_encode($chart_data['earnings'] ?? [500, 800, 1200, 700, 1000, 1500]) !!};
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Bookings',
                    data: bookingsData,
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#3B82F6',
                    pointBorderColor: 'white',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Earnings ($)',
                    data: earningsData,
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#10B981',
                    pointBorderColor: 'white',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'white',
                    titleColor: '#1e3a5f',
                    bodyColor: '#4B5563',
                    borderColor: '#E5E7EB',
                    borderWidth: 1,
                    padding: 12,
                    boxPadding: 6,
                    usePointStyle: true,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.dataset.label === 'Earnings ($)') {
                                label += '$' + context.raw;
                            } else {
                                label += context.raw;
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#9CA3AF'
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#F3F4F6'
                    },
                    ticks: {
                        color: '#9CA3AF'
                    }
                },
                y1: {
                    position: 'right',
                    grid: {
                        drawOnChartArea: false,
                    },
                    ticks: {
                        color: '#9CA3AF'
                    }
                }
            }
        }
    });
});
</script>
@endpush