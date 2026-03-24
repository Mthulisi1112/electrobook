@props(['availableSlots', 'electrician'])

<div class="bg-white rounded-lg border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-[#1e3a5f] mb-4">Available This Week</h3>
    
    @if($availableSlots && $availableSlots->isNotEmpty())
        <div class="space-y-4">
            @foreach($availableSlots as $date => $slots)
                <div>
                    <h4 class="font-medium text-gray-900 mb-2">
                        {{ \Carbon\Carbon::parse($date)->format('l, M j') }}
                    </h4>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($slots as $slot)
                            <a href="{{ route('bookings.create', ['electrician_id' => $slot->electrician_id, 'date' => $date, 'slot_id' => $slot->id]) }}" 
                               class="block text-center px-3 py-2 bg-blue-50 text-[#3b82f6] rounded-md hover:bg-[#3b82f6] hover:text-white transition text-sm cursor-pointer"
                               onclick="event.stopPropagation();">
                                {{ $slot->start_time->format('g:i A') }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-4 text-center">
            <a href="{{ route('bookings.create', ['electrician_id' => $electrician->id]) }}" 
               class="text-sm text-[#3b82f6] hover:text-[#2563eb] inline-flex items-center">
                View full schedule
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    @else
        <div class="text-center py-6">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <p class="mt-2 text-sm text-gray-500">No availability this week</p>
            <p class="text-xs text-gray-400">Check back later or contact the electrician</p>
        </div>
    @endif
</div>