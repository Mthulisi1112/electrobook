@props(['electrician'])

<div class="p-4 hover:bg-gray-50">
    <div class="flex items-center">
        <div class="shrink-0">
            <div class="h-10 w-10 rounded-full bg-[#1e3a5f] flex items-center justify-center text-white font-bold">
                {{ substr($electrician->business_name, 0, 1) }}
            </div>
        </div>
        <div class="ml-3 flex-1">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-gray-900">{{ $electrician->business_name }}</p>
                <div class="flex items-center">
                    <span class="text-sm font-semibold text-[#3b82f6] mr-2">
                        {{ $electrician->bookings_count }} bookings
                    </span>
                    <x-rating-stars :rating="$electrician->reviews_avg_rating ?? 0" size="small" />
                </div>
            </div>
            <p class="text-xs text-gray-500">{{ $electrician->user->email }}</p>
        </div>
    </div>
</div>