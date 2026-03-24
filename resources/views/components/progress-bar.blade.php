@props(['percentage', 'color' => 'blue'])

@php
$colors = [
    'blue' => 'bg-blue-500',
    'green' => 'bg-green-500',
    'amber' => 'bg-amber-500',
    'red' => 'bg-red-500',
    'purple' => 'bg-purple-500',
];
@endphp

<div class="w-full bg-gray-200 rounded-full h-2">
    <div class="h-2 rounded-full {{ $colors[$color] }}" 
         style="width: {{ min(100, max(0, $percentage)) }}%">
    </div>
</div>