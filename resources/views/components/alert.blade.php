@props(['type' => 'success'])

@php
$colors = [
    'success' => 'bg-green-100 border-green-400 text-green-700',
    'error' => 'bg-red-100 border-red-400 text-red-700',
    'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-700',
    'info' => 'bg-blue-100 border-blue-400 text-blue-700',
];
@endphp

@if(session($type))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="{{ $colors[$type] }} border px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session($type) }}</span>
        </div>
    </div>
@endif