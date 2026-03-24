@props(['services'])

<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Most Popular Services</h2>
    
    @if($services->isNotEmpty())
        <div class="space-y-4">
            @foreach($services as $index => $service)
                @php
                    $maxBookings = $services->max('total');
                    $percentage = $maxBookings > 0 ? ($service->total / $maxBookings) * 100 : 0;
                @endphp
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <div class="flex items-center">
                            <span class="w-6 h-6 flex items-center justify-center rounded-full bg-gray-100 text-xs font-semibold text-gray-600 mr-2">
                                {{ $index + 1 }}
                            </span>
                            <span class="text-sm font-medium text-gray-900">{{ $service->name }}</span>
                        </div>
                        <span class="text-sm font-semibold text-[#3b82f6]">{{ $service->total }} bookings</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full bg-[#3b82f6]" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500 text-center py-4">No service data available</p>
    @endif
</div>