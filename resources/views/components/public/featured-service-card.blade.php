@props(['service'])

<div class="bg-gradient-to-br from-amber-50 to-white rounded-xl border border-amber-200 p-5 hover:shadow-md transition-all duration-300">
    <!-- Featured Badge -->
    <div class="flex items-center gap-1.5 mb-3">
        <div class="flex items-center gap-1 px-2 py-1 bg-amber-100 rounded-full">
            <svg class="w-3 h-3 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            <span class="text-xs font-medium text-amber-700">Featured</span>
        </div>
        @if(isset($badge) && $badge === 'popular')
            <div class="flex items-center gap-1 px-2 py-1 bg-blue-100 rounded-full">
                <svg class="w-3 h-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05c-1.011 1.111-1.945 2.45-2.6 3.948-1.023 2.334-1.544 4.997-1.544 7.003 0 2.379 1.73 4.518 4.026 4.999a4.5 4.5 0 01.941 0c2.296-.48 4.026-2.62 4.026-4.999 0-.997-.144-2.115-.484-3.308.729.351 1.507.56 2.304.56 2.156 0 4.004-1.487 4.004-3.5 0-1.567-.932-3.013-2.335-3.776.12-.66.207-1.325.207-1.997 0-1.083-.187-2.12-.522-3.07z" clip-rule="evenodd"/>
                </svg>
                <span class="text-xs font-medium text-blue-700">Popular</span>
            </div>
        @endif
    </div>

    <!-- Service Info -->
    <div class="mb-3">
        <h3 class="font-semibold text-gray-900 text-lg mb-1">{{ $service->name }}</h3>
        <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed">{{ $service->description }}</p>
    </div>

    <!-- Meta Info -->
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2 text-sm text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ $service->estimated_duration_minutes }} min</span>
        </div>
        <div class="text-right">
            <span class="text-xs text-gray-500 block">Starting at</span>
            <span class="text-lg font-bold text-[#1e3a5f]">${{ number_format($service->base_price, 0) }}</span>
        </div>
    </div>

    <!-- Action Link - Lighter version -->
    <a href="{{ route('services.show', $service) }}" 
       class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-[#1e3a5f] transition-colors group">
        <span>View details</span>
        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </a>
</div>