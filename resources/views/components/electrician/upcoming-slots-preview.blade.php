@props(['slots'])

@if($slots->isNotEmpty())
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 mb-8">
        <h3 class="text-lg font-semibold text-[#1e3a5f] mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            Your Upcoming Availability
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            @foreach($slots as $slot)
                <div class="bg-white rounded-lg p-3 text-center shadow-sm">
                    <p class="text-sm font-medium text-[#1e3a5f]">{{ $slot->date->format('D, M j') }}</p>
                    <p class="text-xs text-gray-500">{{ $slot->start_time->format('g:i A') }}</p>
                </div>
            @endforeach
        </div>
        <div class="mt-4 text-right">
            <a href="{{ route('availability.index') }}" class="text-sm text-[#3b82f6] hover:text-[#2563eb] font-medium">
                View all slots →
            </a>
        </div>
    </div>
@endif