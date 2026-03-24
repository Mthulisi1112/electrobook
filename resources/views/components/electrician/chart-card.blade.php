@props(['title', 'labels', 'bookings', 'earnings'])

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold text-[#1e3a5f] mb-4">{{ $title }}</h3>
    
    <div class="space-y-4">
        @foreach($labels as $index => $label)
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">{{ $label }}</span>
                    <div class="text-right">
                        <span class="font-semibold text-[#1e3a5f]">{{ $bookings[$index] }} bookings</span>
                        @if($earnings[$index] > 0)
                            <span class="text-xs text-gray-500 ml-2">${{ number_format($earnings[$index], 0) }}</span>
                        @endif
                    </div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="h-2 rounded-full bg-[#3b82f6]" 
                         style="width: {{ $bookings[$index] > 0 ? ($bookings[$index] / max($bookings) * 100) : 0 }}%">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>