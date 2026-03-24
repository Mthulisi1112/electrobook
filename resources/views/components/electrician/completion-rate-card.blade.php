@props(['completed', 'total'])

@php
$rate = $total > 0 ? round(($completed / $total) * 100) : 0;
@endphp

<div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-[#1e3a5f]">Completion Rate</h3>
        <span class="text-3xl font-bold text-[#3b82f6]">{{ $rate }}%</span>
    </div>
    <div class="w-full bg-gray-200 rounded-full h-2.5">
        <div class="bg-green-500 h-2.5 rounded-full transition-all duration-500" 
             style="width: {{ $rate }}%"></div>
    </div>
    <p class="text-xs text-gray-500 mt-2">{{ $completed }} of {{ $total }} jobs completed</p>
</div>