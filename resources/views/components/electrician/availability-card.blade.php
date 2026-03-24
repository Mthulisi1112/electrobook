@props(['availableSlots', 'route'])

<div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-[#1e3a5f]">Available Slots</h3>
        <span class="text-3xl font-bold text-[#3b82f6]">{{ $availableSlots }}</span>
    </div>
    <a href="{{ $route }}" class="text-[#3b82f6] hover:text-[#2563eb] text-sm flex items-center group">
        Manage Availability
        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </a>
</div>