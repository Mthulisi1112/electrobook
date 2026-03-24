@props(['service'])

<div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition">
    <div class="p-6">
        <div class="flex items-center mb-4">
            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                <span class="text-xl">{{ $service->icon ?? '🔧' }}</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">{{ $service->name }}</h3>
                <p class="text-xs text-gray-500">Starting at ${{ $service->base_price }}</p>
            </div>
        </div>
        
        <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $service->description }}</p>
        
        <div class="flex items-center justify-between">
            <div class="flex items-center text-xs text-gray-500">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $service->estimated_duration_minutes }} min
            </div>
            
            <!-- Updated link to go to electricians page -->
            <a href="{{ route('service.electricians', ['service' => $service->slug]) }}" 
               class="text-sm text-[#1e3a5f] font-medium hover:underline">
                Find pros →
            </a>
        </div>
    </div>
</div>