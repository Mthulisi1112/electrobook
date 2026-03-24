@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
@php
    dump('=== ADMIN DASHBOARD DEBUG ===');
    dump('Variables passed to admin dashboard:');
    
    dump(isset($recentBookings) ? '✅ $recentBookings exists with ' . $recentBookings->count() . ' items' : '❌ $recentBookings MISSING');
    if(isset($recentBookings) && $recentBookings->count() > 0) {
        $firstBooking = $recentBookings->first();
        dump('First booking sample:', [
            'id' => $firstBooking->id,
            'service_exists' => $firstBooking->service ? 'Yes' : 'No',
            'client_exists' => $firstBooking->client ? 'Yes' : 'No',
            'electrician_exists' => $firstBooking->electrician ? 'Yes' : 'No',
        ]);
    }
    
    dump(isset($recentUsers) ? '✅ $recentUsers exists with ' . $recentUsers->count() . ' items' : '❌ $recentUsers MISSING');
    dump(isset($totalUsers) ? '✅ $totalUsers: ' . $totalUsers : '❌ $totalUsers MISSING');
    dump(isset($totalBookings) ? '✅ $totalBookings: ' . $totalBookings : '❌ $totalBookings MISSING');
    dump(isset($totalRevenue) ? '✅ $totalRevenue: ' . $totalRevenue : '❌ $totalRevenue MISSING');
    
    dump('All compacted variables:', array_keys(get_defined_vars()));
@endphp
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-[#1e3a5f]">Admin Dashboard</h1>
        <p class="text-gray-600 mt-2">Manage your platform, users, and bookings.</p>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- ... your stats cards ... -->
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <!-- ... your quick action cards ... -->
    </div>

    <!-- Recent Activity Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Bookings -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-[#1e3a5f]">Recent Bookings</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentBookings ?? [] as $booking)
                    <div class="p-4 hover:bg-gray-50">
                        @php
                            // Safely get values with null checks
                            $serviceName = optional($booking->service)->name ?? 'N/A';
                            $clientName = optional($booking->client)->name ?? 'Unknown Client';
                            $electricianName = optional($booking->electrician)->business_name ?? 'Unknown Electrician';
                        @endphp
                        <p class="text-sm font-medium">{{ $serviceName }}</p>
                        <p class="text-xs text-gray-500">{{ $clientName }} → {{ $electricianName }}</p>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p>No recent bookings</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-[#1e3a5f]">Recent Users</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentUsers ?? [] as $user)
                    <div class="p-4 hover:bg-gray-50">
                        @php
                            $userName = optional($user)->name ?? 'Unknown User';
                            $userEmail = optional($user)->email ?? 'No email';
                            $userRole = optional($user)->role ?? 'client';
                        @endphp
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-[#1e3a5f] flex items-center justify-center text-white text-xs font-bold">
                                {{ substr($userName, 0, 1) }}
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900">{{ $userName }}</p>
                                    <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                        @if($userRole === 'admin') bg-purple-100 text-purple-800
                                        @elseif($userRole === 'electrician') bg-green-100 text-green-800
                                        @else bg-blue-100 text-blue-800
                                        @endif">
                                        {{ ucfirst($userRole) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500">{{ $userEmail }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <p>No recent users</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection