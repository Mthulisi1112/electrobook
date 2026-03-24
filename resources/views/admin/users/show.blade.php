@extends('layouts.app')

@section('title', $user->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex justify-between items-start mb-8">
        <div>
            <a href="{{ route('admin.users.index') }}" class="text-[#3b82f6] hover:text-[#2563eb] flex items-center mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Users
            </a>
            <div class="flex items-center">
                <div class="h-16 w-16 rounded-full bg-[#1e3a5f] flex items-center justify-center text-white text-2xl font-bold">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div class="ml-4">
                    <h1 class="text-3xl font-bold text-[#1e3a5f]">{{ $user->name }}</h1>
                    <div class="flex items-center mt-2">
                        <x-user-role-badge :role="$user->role" />
                        @if($user->hasVerifiedEmail())
                            <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Email Verified
                            </span>
                        @else
                            <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">
                                Email Unverified
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="flex space-x-3">
            @if($user->id !== auth()->id())
                <form method="POST" action="{{ route('admin.users.impersonate', $user) }}" class="inline">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Impersonate
                    </button>
                </form>
            @endif
            <a href="{{ route('admin.users.edit', $user) }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-center">
                <p class="text-3xl font-bold text-[#1e3a5f]">{{ $stats['total_bookings'] }}</p>
                <p class="text-sm text-gray-500">Total Bookings</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-center">
                <p class="text-3xl font-bold text-green-600">{{ $stats['completed_bookings'] }}</p>
                <p class="text-sm text-gray-500">Completed</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-center">
                <p class="text-3xl font-bold text-purple-600">{{ $stats['total_reviews'] }}</p>
                <p class="text-sm text-gray-500">Reviews Given</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-center">
                <p class="text-sm text-gray-500">Member Since</p>
                <p class="text-lg font-semibold text-[#1e3a5f]">{{ $stats['member_since'] }}</p>
            </div>
        </div>
    </div>

    @if($user->isElectrician() && $user->electrician)
        <!-- Electrician Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-center">
                    <p class="text-3xl font-bold text-[#1e3a5f]">{{ $stats['electrician_bookings'] }}</p>
                    <p class="text-sm text-gray-500">Jobs Completed</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-center">
                    <p class="text-3xl font-bold text-[#3b82f6]">${{ number_format($stats['electrician_earnings'], 2) }}</p>
                    <p class="text-sm text-gray-500">Total Earnings</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-center">
                    <p class="text-3xl font-bold text-amber-600">{{ number_format($stats['average_rating'], 1) }}</p>
                    <p class="text-sm text-gray-500">Average Rating</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- User Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">User Information</h2>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Full Name</p>
                        <p class="font-medium">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email Address</p>
                        <p class="font-medium">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Phone Number</p>
                        <p class="font-medium">{{ $user->phone ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Role</p>
                        <p class="font-medium capitalize">{{ $user->role }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email Verified</p>
                        <p class="font-medium">{{ $user->email_verified_at ? $user->email_verified_at->format('M d, Y') : 'No' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Account Created</p>
                        <p class="font-medium">{{ $user->created_at->format('M d, Y g:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Last Updated</p>
                        <p class="font-medium">{{ $user->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            @if($user->isElectrician() && $user->electrician)
                <!-- Electrician Profile -->
                <div class="bg-white rounded-lg shadow p-6 mt-6">
                    <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Electrician Profile</h2>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Business Name</p>
                            <p class="font-medium">{{ $user->electrician->business_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">License Number</p>
                            <p class="font-medium">{{ $user->electrician->license_number ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Years Experience</p>
                            <p class="font-medium">{{ $user->electrician->years_experience ?? 0 }} years</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Hourly Rate</p>
                            <p class="font-medium text-[#3b82f6]">${{ number_format($user->electrician->hourly_rate ?? 0, 2) }}/hr</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">Bio</p>
                            <p class="font-medium">{{ $user->electrician->bio ?? 'No bio provided.' }}</p>
                        </div>
                        @if($user->electrician->service_areas)
                            <div class="col-span-2">
                                <p class="text-sm text-gray-500 mb-2">Service Areas</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($user->electrician->service_areas as $area)
                                        <span class="px-3 py-1 bg-gray-100 rounded-full text-sm text-gray-700">{{ $area }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Recent Bookings -->
            @if($user->clientBookings->isNotEmpty())
                <div class="bg-white rounded-lg shadow p-6 mt-6">
                    <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Recent Bookings (as client)</h2>
                    
                    <div class="space-y-3">
                        @foreach($user->clientBookings as $booking)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium">{{ $booking->service->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $booking->booking_date->format('M d, Y') }}</p>
                                </div>
                                <x-booking-status-badge :status="$booking->status" />
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Actions Card -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Actions</h2>
                
                <div class="space-y-3">
                    @if(!$user->hasVerifiedEmail())
                        <form method="POST" action="{{ route('admin.users.verify-email', $user) }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                Verify Email
                            </button>
                        </form>
                    @endif

                    @if($user->id !== auth()->id())
                        <a href="{{ route('admin.users.edit', $user) }}" 
                           class="block w-full px-4 py-2 bg-[#3b82f6] text-white rounded-md hover:bg-[#2563eb] text-center">
                            Edit User
                        </a>
                    @endif
                </div>
            </div>

            <!-- Activity Log -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Recent Activity</h2>
                
                @if($user->clientBookings->isNotEmpty() || $user->reviews->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($user->clientBookings->take(5) as $booking)
                            <div class="text-sm">
                                <span class="text-gray-500">{{ $booking->created_at->diffForHumans() }}</span>
                                <p class="text-gray-900">Booked {{ $booking->service->name }}</p>
                            </div>
                        @endforeach
                        
                        @foreach($user->reviews->take(5) as $review)
                            <div class="text-sm">
                                <span class="text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                <p class="text-gray-900">Left a {{ $review->rating }}-star review</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No recent activity</p>
                @endif
            </div>

            <!-- Danger Zone (Admin only) -->
            @if($user->id !== auth()->id())
                <div class="bg-white rounded-lg shadow p-6 mt-6 border-2 border-red-200">
                    <h2 class="text-xl font-semibold text-red-600 mb-4">Danger Zone</h2>
                    
                    <div class="space-y-3">
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                              onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                Delete User
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection