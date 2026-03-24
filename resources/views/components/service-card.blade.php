@props(['service'])

<div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition group">
    <div class="p-6">
        <!-- Icon -->
        <div class="mb-4">
            <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-[#3b82f6] transition">
                @if($service->icon)
                    <span class="text-3xl">{{ $service->icon }}</span>
                @else
                    <svg class="w-8 h-8 text-[#3b82f6] group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                @endif
            </div>
        </div>

        <!-- Content -->
        <h3 class="text-xl font-semibold text-[#1e3a5f] mb-2">{{ $service->name }}</h3>
        <p class="text-gray-600 mb-4 line-clamp-2">{{ $service->description }}</p>

        <!-- Details -->
        <div class="space-y-2 mb-4">
            <div class="flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ $service->estimated_duration_minutes }} minutes</span>
            </div>
            <div class="flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-5-5A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <span>{{ $service->category }}</span>
            </div>
            <div class="flex items-center text-sm text-gray-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span>{{ $service->electricians_count ?? 0 }} electricians available</span>
            </div>
        </div>

        <!-- Price and CTA -->
        <div class="flex items-center justify-between">
            <div>
                <span class="text-sm text-gray-500">Starting from</span>
                <p class="text-2xl font-bold text-[#3b82f6]">${{ number_format($service->base_price, 2) }}</p>
            </div>
            <a href="{{ route('services.show', $service) }}" 
               class="inline-flex items-center px-4 py-2 bg-[#3b82f6] text-white rounded-lg hover:bg-[#2563eb] transition">
                View Details
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</div>