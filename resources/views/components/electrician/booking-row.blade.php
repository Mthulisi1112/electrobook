@props(['booking'])

<div class="p-6 hover:bg-gray-50 transition">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div class="flex-1">
            <div class="flex items-center space-x-3 mb-2">
                <x-booking.status-badge :status="$booking->status" />
                <span class="text-sm text-gray-500">#{{ $booking->booking_number }}</span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Client</p>
                    <p class="font-medium text-gray-900">{{ $booking->client->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Service</p>
                    <p class="font-medium text-gray-900">{{ $booking->service->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Date & Time</p>
                    <p class="font-medium text-gray-900">
                        {{ $booking->booking_date->format('M d, Y') }} at {{ $booking->start_time->format('g:i A') }}
                    </p>
                </div>
            </div>

            @if($booking->status === 'pending')
                <div class="mt-4 flex space-x-3">
                    <form method="POST" action="{{ route('bookings.confirm', $booking) }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700 transition shadow-sm">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Confirm
                        </button>
                    </form>
                    
                    <button onclick="showCancelModal({{ $booking->id }}, '{{ $booking->booking_number }}')"
                            class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 text-sm rounded-md hover:bg-red-200 transition">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Decline
                    </button>
                </div>
            @endif
        </div>
        
        <div class="mt-4 md:mt-0 md:ml-4">
            <a href="{{ route('bookings.show', $booking) }}" 
               class="inline-flex items-center text-[#3b82f6] hover:text-[#2563eb] font-medium group">
                View Details
                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</div>