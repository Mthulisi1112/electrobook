@props(['title', 'value', 'icon', 'color' => 'blue'])

@php
$colors = [
    'blue' => 'bg-blue-100 text-blue-600',
    'green' => 'bg-green-100 text-green-600',
    'amber' => 'bg-amber-100 text-amber-600',
    'purple' => 'bg-purple-100 text-purple-600',
    'red' => 'bg-red-100 text-red-600',
    'indigo' => 'bg-indigo-100 text-indigo-600',
];
@endphp

<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-center">
        <div class="p-3 {{ $colors[$color] }} rounded-full">
             {!! $icon !!}
        </div>
        <div class="ml-4">
            <p class="text-sm text-gray-500">{{ $title }}</p>
            <p class="text-2xl font-semibold text-[#1e3a5f]">{{ $value }}</p>
        </div>
    </div>
</div>