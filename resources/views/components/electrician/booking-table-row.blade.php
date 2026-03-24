@props(['booking'])

<tr class="hover:bg-gray-50 transition">
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center">
            <div class="shrink-0 h-10 w-10">
                <div class="h-10 w-10 rounded-full bg-[#1e3a5f] flex items-center justify-center text-white font-bold">
                    {{ substr($booking->client->name, 0, 1) }}
                </div>
            </div>
            <div class="ml-4">
                <div class="text-sm font-medium text-gray-900">{{ $booking->client->name }}</div>
                <div class="text-sm text-gray-500">{{ $booking->booking_number }}</div>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-900">{{ $booking->service->name }}</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-900">{{ $booking->booking_date->format('M d, Y') }}</div>
        <div class="text-sm text-gray-500">{{ $booking->start_time->format('g:i A') }} - {{ $booking->end_time->format('g:i A') }}</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm font-semibold text-[#3b82f6]">${{ number_format($booking->total_amount, 2) }}</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <x-booking-status-badge :status="$booking->status" />
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('electrician.bookings.show', $booking) }}" 
               class="text-[#3b82f6] hover:text-[#2563eb]" title="View Details">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </a>

            @if($booking->status === 'pending')
                <form method="POST" action="{{ route('electrician.bookings.confirm', $booking) }}" class="inline">
                    @csrf
                    <button type="submit" class="text-green-600 hover:text-green-900" title="Confirm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </button>
                </form>
            @endif

            @if($booking->status === 'confirmed')
                <form method="POST" action="{{ route('electrician.bookings.complete', $booking) }}" class="inline">
                    @csrf
                    <button type="submit" class="text-blue-600 hover:text-blue-900" title="Mark Complete">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </button>
                </form>
            @endif

            @if(in_array($booking->status, ['pending', 'confirmed']))
                <button onclick="showCancelModal({{ $booking->id }}, '{{ $booking->booking_number }}')" 
                        class="text-red-600 hover:text-red-900" title="Cancel">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            @endif
        </div>
    </td>
</tr>