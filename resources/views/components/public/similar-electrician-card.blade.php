@props(['electrician'])

<div class="bg-white rounded-lg shadow p-4 hover:shadow-md transition">
    <div class="flex items-center mb-3">
        <div class="h-12 w-12 rounded-full bg-[#1e3a5f] flex items-center justify-center text-white font-bold text-lg">
            {{ substr($electrician->business_name, 0, 1) }}
        </div>
        <div class="ml-3">
            <h4 class="font-medium text-[#1e3a5f]">{{ $electrician->business_name }}</h4>
            <div class="flex items-center text-sm">
                <div class="flex text-amber-400">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($electrician->reviews_avg_rating ?? 0))
                            ★
                        @else
                            ☆
                        @endif
                    @endfor
                </div>
                <span class="ml-1 text-xs text-gray-500">({{ $electrician->reviews_count ?? 0 }})</span>
            </div>
        </div>
    </div>
    
    <div class="flex items-center justify-between">
        <span class="text-sm font-semibold text-[#3b82f6]">${{ number_format($electrician->hourly_rate, 2) }}/hr</span>
        <a href="{{ route('electricians.show', $electrician) }}" 
           class="text-sm text-[#3b82f6] hover:text-[#2563eb]">
            View Profile →
        </a>
    </div>
</div>