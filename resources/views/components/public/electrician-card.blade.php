@props(['electrician'])

@php
    // Decode service_areas if it's a JSON string
    $serviceAreas = is_string($electrician->service_areas) 
        ? json_decode($electrician->service_areas, true) 
        : $electrician->service_areas;
    
    // If it's still not an array, make it an empty array
    $serviceAreas = is_array($serviceAreas) ? $serviceAreas : [];
@endphp

<div class="bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-300 overflow-hidden">
    <div class="p-5">
        <div class="flex items-start gap-4 mb-4">
            <!-- Avatar -->
            <div class="w-16 h-16 rounded-full bg-[#1e3a5f] flex items-center justify-center text-white text-xl font-bold flex-shrink-0">
                {{ substr($electrician->business_name, 0, 1) }}
            </div>
            
            <!-- Info -->
            <div class="flex-1 min-w-0">
                <h3 class="font-semibold text-gray-900 text-lg truncate">{{ $electrician->business_name }}</h3>
                <p class="text-sm text-gray-500">{{ $electrician->years_experience }} years experience</p>
                
                <!-- Rating -->
                <div class="flex items-center mt-1">
                    <div class="flex text-amber-400">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($electrician->reviews_avg_rating ?? 0))
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">★</svg>
                            @else
                                <svg class="w-4 h-4 fill-current text-gray-300" viewBox="0 0 20 20">★</svg>
                            @endif
                        @endfor
                    </div>
                    <span class="text-xs text-gray-500 ml-2">({{ $electrician->reviews_count ?? 0 }} reviews)</span>
                </div>
            </div>
        </div>

        <!-- Bio -->
        <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $electrician->bio ?? 'Professional electrician ready to help with your electrical needs.' }}</p>

        <!-- Service Areas - FIXED -->
        @if(!empty($serviceAreas))
            <div class="mb-4">
                <div class="flex flex-wrap gap-1">
                    @foreach(array_slice($serviceAreas, 0, 2) as $area)
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">{{ $area }}</span>
                    @endforeach
                    @if(count($serviceAreas) > 2)
                        <span class="text-xs text-gray-400">+{{ count($serviceAreas) - 2 }} more</span>
                    @endif
                </div>
            </div>
        @endif

        <!-- Footer -->
        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
            <div>
                <span class="text-xs text-gray-500">Starting at</span>
                <p class="text-lg font-bold text-[#1e3a5f]">${{ number_format($electrician->hourly_rate, 0) }}/hr</p>
            </div>
            <a href="{{ route('electricians.show', $electrician) }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-50 text-[#1e3a5f] text-sm font-medium rounded-lg hover:bg-gray-100 transition group">
                View profile
                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</div>