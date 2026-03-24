@props(['status', 'count', 'total', 'color'])

@php
$colors = [
    'completed' => 'bg-green-500',
    'cancelled' => 'bg-red-500',
    'confirmed' => 'bg-blue-500',
    'pending' => 'bg-amber-500',
];
$percentage = $total > 0 ? ($count / $total) * 100 : 0;
@endphp

<div>
    <div class="flex justify-between text-sm mb-1">
        <span class="capitalize">{{ $status }}</span>
        <span class="font-semibold">{{ $count }}</span>
    </div>
    <div class="w-full bg-gray-200 rounded-full h-2">
        <div class="h-2 rounded-full {{ $colors[$status] ?? 'bg-gray-500' }}" 
             style="width: {{ $percentage }}%">
        </div>
    </div>
</div>