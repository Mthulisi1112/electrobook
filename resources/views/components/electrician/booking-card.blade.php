@props(['booking', 'type' => 'upcoming'])

<div class="bg-white rounded-lg shadow p-4 hover:shadow-md transition">
    <div class="flex items-start justify-between mb-3">
        <div class="flex items-center">
            <div class="h-10 w-10 rounded-full bg-[#1e3a5f] flex items-center justify-center text-white font-bold">
                {{ substr($booking->client->name, 0, 1) }}
            </div>
            <div class="ml-3">
                <p class="font-medium text-gray-900">{{ $booking->client->name }}</p>
                <p class="text-xs text-gray-500">{{ $booking->booking_number }}</p>
            </div>
        </div>
        <x-booking-status-badge :status="$booking->status" />
    </div>

    <div class="space-y-2 mb-3">
        <div class="flex items-center text-sm">
            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
            <span>{{ $booking->service->name }}</span>
        </div>
        <div class="flex items-center text-sm">
            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span>{{ $booking->booking_date->format('D, M j, Y') }}</span>
        </div>
        <div class="flex items-center text-sm">
            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>{{ $booking->start_time->format('g:i A') }} - {{ $booking->end_time->format('g:i A') }}</span>
        </div>
    </div>

    <div class="flex items-center justify-between pt-2 border-t">
        <span class="text-sm font-semibold text-[#3b82f6]">${{ number_format($booking->total_amount, 2) }}</span>
        <a href="{{ route('electrician.bookings.show', $booking) }}" 
           class="text-sm text-[#3b82f6] hover:text-[#2563eb]">
            View Details →
        </a>
    </div>
</div>