@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Welcome Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-[#1e3a5f]">My Dashboard</h1>
        <p class="text-gray-600 mt-2">Welcome back, {{ auth()->user()->name }}! Manage your bookings and profile.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Bookings</p>
                    <p class="text-2xl font-semibold text-[#1e3a5f]">{{ $totalBookings }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Completed</p>
                    <p class="text-2xl font-semibold text-[#1e3a5f]">{{ $completedBookings }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-amber-100 rounded-full">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Pending</p>
                    <p class="text-2xl font-semibold text-[#1e3a5f]">{{ $pendingBookings }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Reviews Given</p>
                    <p class="text-2xl font-semibold text-[#1e3a5f]">{{ $reviewsCount ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <a href="{{ route('bookings.create') }}" 
           class="bg-white p-4 rounded-lg shadow hover:shadow-md transition flex items-center group border-2 border-transparent hover:border-blue-200">
            <div class="p-3 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition mr-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900">Book New Service</h4>
                <p class="text-sm text-gray-500">Find an electrician</p>
            </div>
        </a>

        <a href="{{ route('electricians.index') }}" 
           class="bg-white p-4 rounded-lg shadow hover:shadow-md transition flex items-center group border-2 border-transparent hover:border-green-200">
            <div class="p-3 bg-green-100 rounded-lg group-hover:bg-green-200 transition mr-4">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900">Find Electricians</h4>
                <p class="text-sm text-gray-500">Browse professionals</p>
            </div>
        </a>

        <a href="{{ route('profile.edit') }}" 
           class="bg-white p-4 rounded-lg shadow hover:shadow-md transition flex items-center group border-2 border-transparent hover:border-purple-200">
            <div class="p-3 bg-purple-100 rounded-lg group-hover:bg-purple-200 transition mr-4">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-gray-900">Profile Settings</h4>
                <p class="text-sm text-gray-500">Update your info</p>
            </div>
        </a>
    </div>

    <!-- Upcoming Appointments -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-[#1e3a5f]">Upcoming Appointments</h2>
            <a href="{{ route('bookings.index') }}" class="text-sm text-[#3b82f6] hover:text-[#2563eb]">View All</a>
        </div>
        
        @if($upcomingBookings->isNotEmpty())
            <div class="divide-y divide-gray-200">
                @foreach($upcomingBookings as $booking)
                    <div class="p-4 hover:bg-gray-50">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium">{{ $booking->service->name }}</p>
                                <p class="text-sm text-gray-600">with {{ $booking->electrician->business_name }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }} at 
                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }}
                                </p>
                            </div>
                            <a href="{{ route('bookings.show', $booking) }}" 
                               class="text-sm text-[#3b82f6] hover:text-[#2563eb]">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 text-center text-gray-500">
                No upcoming appointments
            </div>
        @endif
    </div>

    <!-- Recent Bookings -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-[#1e3a5f]">Recent Bookings</h2>
            <a href="{{ route('bookings.index') }}" class="text-sm text-[#3b82f6] hover:text-[#2563eb]">View All</a>
        </div>
        
        @if($recentBookings->isNotEmpty())
            <div class="divide-y divide-gray-200">
                @foreach($recentBookings as $booking)
                    <div class="p-4 hover:bg-gray-50">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium">{{ $booking->service->name }}</p>
                                <p class="text-sm text-gray-600">{{ $booking->electrician->business_name }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($booking->status === 'completed') bg-green-100 text-green-800
                                @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                @elseif($booking->status === 'confirmed') bg-blue-100 text-blue-800
                                @else bg-amber-100 text-amber-800
                                @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 text-center text-gray-500">
                No bookings yet
            </div>
        @endif
    </div>
</div>
@endsection