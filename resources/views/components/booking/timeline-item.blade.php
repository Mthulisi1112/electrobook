@props(['status', 'date', 'description', 'active' => false, 'last' => false])

<div class="flex items-start {{ !$last ? 'mb-4' : '' }}">
    <div class="shrink-0">
        <div class="h-8 w-8 rounded-full {{ $active ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
            @if($status === 'completed')
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            @elseif($status === 'cancelled')
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            @else
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            @endif
        </div>
    </div>
    <div class="ml-3">
        <p class="text-sm font-medium text-gray-900">{{ $description }}</p>
        <p class="text-xs text-gray-500">{{ $date }}</p>
    </div>
</div>