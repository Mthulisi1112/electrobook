@extends('layouts.app')

@section('title', 'Booking #' . $booking->booking_number)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('electrician.bookings.index') }}" class="text-[#3b82f6] hover:text-[#2563eb] flex items-center mb-4">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Bookings
        </a>

        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-[#1e3a5f]">Booking #{{ $booking->booking_number }}</h1>
                <p class="text-gray-600 mt-2">View and manage this booking</p>
            </div>
            <div class="flex space-x-3">
                @if($booking->status === 'pending')
                    <form method="POST" action="{{ route('electrician.bookings.confirm', $booking) }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Confirm Booking
                        </button>
                    </form>
                @endif

                @if($booking->status === 'confirmed')
                    <form method="POST" action="{{ route('electrician.bookings.complete', $booking) }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Mark Complete
                        </button>
                    </form>
                @endif

                @if(in_array($booking->status, ['pending', 'confirmed']))
                    <button onclick="showCancelModal()" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel Booking
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Status Banner -->
    <div class="mb-8">
        <x-booking-status-badge :status="$booking->status" size="large" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Booking Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Booking Details</h2>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Service</p>
                        <p class="font-medium">{{ $booking->service->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Date</p>
                        <p class="font-medium">{{ $booking->booking_date->format('l, F j, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Start Time</p>
                        <p class="font-medium">{{ $booking->start_time->format('g:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">End Time</p>
                        <p class="font-medium">{{ $booking->end_time->format('g:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Duration</p>
                        <p class="font-medium">{{ $booking->start_time->diffInHours($booking->end_time) }} hours</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Amount</p>
                        <p class="font-medium text-[#3b82f6]">${{ number_format($booking->total_amount, 2) }}</p>
                    </div>
                </div>

                @if($booking->description)
                    <div class="mt-4 pt-4 border-t">
                        <p class="text-sm text-gray-500 mb-2">Job Description</p>
                        <p class="text-gray-700">{{ $booking->description }}</p>
                    </div>
                @endif
            </div>

            <!-- Location Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Service Location</h2>
                
                <div class="space-y-2">
                    <p class="text-gray-700">{{ $booking->address }}</p>
                    <p class="text-gray-700">{{ $booking->city }}, {{ $booking->postal_code }}</p>
                </div>

                <!-- Map placeholder - can integrate with Google Maps later -->
                <div class="mt-4 bg-gray-100 rounded-lg h-48 flex items-center justify-center">
                    <p class="text-gray-500">Map view coming soon</p>
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Booking Timeline</h2>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="shrink-0">
                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">Booking Created</p>
                            <p class="text-sm text-gray-500">{{ $booking->created_at->format('M d, Y g:i A') }}</p>
                        </div>
                    </div>

                    @if($booking->status === 'confirmed' || $booking->status === 'completed')
                        <div class="flex items-start">
                            <div class="shrink-0">
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Booking Confirmed</p>
                                <p class="text-sm text-gray-500">{{ $booking->updated_at->format('M d, Y g:i A') }}</p>
                            </div>
                        </div>
                    @endif

                    @if($booking->status === 'completed')
                        <div class="flex items-start">
                            <div class="shrink-0">
                                <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Booking Completed</p>
                                <p class="text-sm text-gray-500">{{ $booking->updated_at->format('M d, Y g:i A') }}</p>
                            </div>
                        </div>
                    @endif

                    @if($booking->status === 'cancelled')
                        <div class="flex items-start">
                            <div class="shrink-0">
                                <div class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center">
                                    <svg class="h-4 w-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Booking Cancelled</p>
                                <p class="text-sm text-gray-500">{{ $booking->cancelled_at->format('M d, Y g:i A') }}</p>
                                <p class="text-sm text-gray-600 mt-1">Reason: {{ $booking->cancellation_reason }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Client Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Client Information</h2>
                
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-[#1e3a5f] flex items-center justify-center text-white text-lg font-bold">
                        {{ substr($booking->client->name, 0, 1) }}
                    </div>
                    <div class="ml-3">
                        <p class="font-medium text-gray-900">{{ $booking->client->name }}</p>
                        <p class="text-sm text-gray-500">{{ $booking->client->email }}</p>
                    </div>
                </div>

                @if($booking->client->phone)
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        {{ $booking->client->phone }}
                    </div>
                @endif

                <div class="mt-4 pt-4 border-t">
                    <p class="text-sm text-gray-500">Member since</p>
                    <p class="font-medium">{{ $booking->client->created_at->format('F Y') }}</p>
                </div>
            </div>

            <!-- Review Section -->
            @if($booking->review)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Client Review</h2>
                    
                    <div class="flex items-center mb-2">
                        <div class="flex text-amber-400">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $booking->review->rating)
                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 fill-current text-gray-300" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="ml-2 text-sm text-gray-600">{{ $booking->review->created_at->diffForHumans() }}</span>
                    </div>
                    
                    @if($booking->review->comment)
                        <p class="text-gray-700 mt-2">"{{ $booking->review->comment }}"</p>
                    @endif
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Quick Actions</h2>
                
                <div class="space-y-3">
                    <a href="#" class="block w-full text-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Message Client
                    </a>
                    
                    <a href="#" class="block w-full text-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        View on Map
                    </a>
                    
                    @if($booking->status === 'completed' && !$booking->review)
                        <p class="text-sm text-gray-500 text-center pt-2">
                            Waiting for client review
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Modal -->
<div id="cancelModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h3 class="text-lg font-semibold text-red-600 mb-4">Cancel Booking</h3>
        <form method="POST" action="{{ route('electrician.bookings.cancel', $booking) }}" id="cancelForm">
            @csrf
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-4">
                    Are you sure you want to cancel booking #{{ $booking->booking_number }}?
                </p>
                <label for="cancellation_reason" class="block text-sm font-medium text-gray-700 mb-1">
                    Reason for cancellation *
                </label>
                <textarea name="cancellation_reason" 
                          id="cancellation_reason" 
                          rows="3" 
                          required
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                          placeholder="Please provide a reason for cancelling this booking..."></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="hideCancelModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Close
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Confirm Cancellation
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showCancelModal() {
    document.getElementById('cancelModal').classList.remove('hidden');
    document.getElementById('cancelModal').classList.add('flex');
}

function hideCancelModal() {
    document.getElementById('cancelModal').classList.add('hidden');
    document.getElementById('cancelModal').classList.remove('flex');
    document.getElementById('cancellation_reason').value = '';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('cancelModal');
    if (event.target === modal) {
        hideCancelModal();
    }
}
</script>
@endsection