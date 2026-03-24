@props(['booking'])

<div class="p-4 hover:bg-gray-50">
    <div class="flex justify-between items-start">
        <div>
            <div class="flex items-center space-x-2 mb-1">
                <x-booking-status-badge :status="$booking->status" />
                <span class="text-xs text-gray-500">#{{ $booking->booking_number }}</span>
            </div>
            <p class="text-sm font-medium text-gray-900">{{ $booking->service->name }}</p>
            <p class="text-xs text-gray-500">
                {{ $booking->client->name }} → {{ $booking->electrician->business_name }}
            </p>
            <p class="text-xs text-gray-400 mt-1">
                {{ $booking->booking_date->format('M d, Y') }}
            </p>
        </div>
        <span class="text-sm font-semibold text-[#3b82f6]">
            ${{ number_format($booking->total_amount, 2) }}
        </span>
    </div>
</div>