@props(['electrician'])

<div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-[#3b82f6] hover:shadow-md transition">
    <div class="flex items-center">
        <div class="h-14 w-14 rounded-full bg-[#1e3a5f] flex items-center justify-center text-white text-xl font-bold">
            {{ substr($electrician->business_name, 0, 1) }}
        </div>
        <div class="ml-4">
            <h4 class="font-semibold text-[#1e3a5f]">{{ $electrician->business_name }}</h4>
            <div class="flex items-center mt-1">
                <div class="flex text-amber-400">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($electrician->reviews_avg_rating ?? 0))
                            ★
                        @else
                            ☆
                        @endif
                    @endfor
                </div>
                <span class="ml-2 text-xs text-gray-500">
                    ({{ $electrician->reviews_count ?? 0 }} reviews)
                </span>
            </div>
            <p class="text-xs text-gray-600 mt-1">{{ $electrician->years_experience }} years experience</p>
        </div>
    </div>
    <div class="text-right">
        <p class="text-lg font-bold text-[#3b82f6]">${{ number_format($electrician->hourly_rate, 2) }}/hr</p>
        <a href="{{ route('bookings.create', ['electrician_id' => $electrician->id]) }}" 
           class="mt-2 inline-block text-sm text-[#3b82f6] hover:text-[#2563eb]">
            Book Now →
        </a>
    </div>
</div>