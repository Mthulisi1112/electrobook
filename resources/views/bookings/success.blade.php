@extends('layouts.app')

@section('title', 'Booking Confirmed')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Success Header -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-[#1e3a5f] mb-2">Booking Confirmed!</h1>
        <p class="text-gray-600">Your appointment has been successfully scheduled.</p>
    </div>

    <!-- Booking Details Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-[#1e3a5f] to-[#3b82f6] px-6 py-4">
            <h2 class="text-xl font-semibold text-white">Booking Details</h2>
        </div>
        
        <div class="p-6">
            <!-- Booking Reference -->
            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                <p class="text-sm text-gray-600 mb-1">Booking Reference</p>
                <p class="text-2xl font-mono font-bold text-[#1e3a5f]">{{ $booking->booking_reference }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Electrician Info -->
                <div class="border-b md:border-b-0 md:border-r border-gray-200 pb-4 md:pb-0 md:pr-6">
                    <h3 class="font-semibold text-[#1e3a5f] mb-3">Electrician</h3>
                    <div class="flex items-center">
                        <div class="h-12 w-12 rounded-full bg-[#1e3a5f] flex items-center justify-center text-white text-lg font-bold">
                            {{ substr($booking->electrician->business_name, 0, 1) }}
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">{{ $booking->electrician->business_name }}</p>
                            <p class="text-sm text-gray-500">{{ $booking->electrician->years_experience }} years experience</p>
                        </div>
                    </div>
                </div>

                <!-- Service Info -->
                <div class="pb-4 md:pb-0">
                    <h3 class="font-semibold text-[#1e3a5f] mb-3">Service</h3>
                    <p class="font-medium text-gray-900">{{ $booking->service->name }}</p>
                    <p class="text-sm text-gray-500">{{ $booking->service->estimated_duration_minutes }} minutes</p>
                </div>
            </div>

            <!-- Date & Time -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-gray-200">
                <div>
                    <h3 class="font-semibold text-[#1e3a5f] mb-2">Date</h3>
                    <div class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($booking->booking_date)->format('l, F j, Y') }}</span>
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold text-[#1e3a5f] mb-2">Time</h3>
                    <div class="flex items-center text-gray-700">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('g:i A') }}</span>
                    </div>
                </div>
            </div>

            <!-- Location -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h3 class="font-semibold text-[#1e3a5f] mb-2">Service Location</h3>
                <div class="flex items-start text-gray-700">
                    <svg class="w-5 h-5 mr-2 mt-0.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>{{ $booking->address }}, {{ $booking->city }}, {{ $booking->postal_code }}</span>
                </div>
            </div>

            <!-- Price -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="font-semibold text-[#1e3a5f]">Total Amount</h3>
                    <p class="text-2xl font-bold text-[#3b82f6]">${{ number_format($booking->total_amount, 2) }}</p>
                </div>
            </div>

            @if($booking->description)
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h3 class="font-semibold text-[#1e3a5f] mb-2">Job Description</h3>
                <p class="text-gray-700">{{ $booking->description }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row justify-center gap-4">
        <a href="{{ route('bookings.show', $booking) }}" 
           class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#3b82f6] hover:bg-[#2563eb] transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
            View Booking Details
        </a>
        <a href="{{ route('bookings.create') }}" 
           class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Book Another Service
        </a>
    </div>

    <!-- What's Next Section -->
    <div class="mt-8 bg-gray-50 rounded-lg p-6">
        <h3 class="font-semibold text-[#1e3a5f] mb-4">What's Next?</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 font-bold">1</span>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">Confirmation Email</p>
                    <p class="text-xs text-gray-500">You'll receive a confirmation email shortly</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 font-bold">2</span>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">Electrician Prepares</p>
                    <p class="text-xs text-gray-500">The electrician will prepare for your appointment</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 font-bold">3</span>
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">Day of Service</p>
                    <p class="text-xs text-gray-500">The electrician will arrive at your scheduled time</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection