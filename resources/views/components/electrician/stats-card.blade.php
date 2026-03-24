@props(['title', 'value', 'icon', 'color' => 'blue', 'trend' => null, 'trendValue' => null])

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
    <div class="flex items-center justify-between mb-4">
        <div class="p-3 {{ $colors[$color] }} rounded-full">
           {!! $icon !!}
        </div>
        @if($trend)
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                {{ $trend === 'up' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if($trend === 'up')
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                    @else
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    @endif
                </svg>
                {{ $trendValue }}
            </span>
        @endif
    </div>
    <p class="text-sm text-gray-500 mb-1">{{ $title }}</p>
    <p class="text-3xl font-bold text-[#1e3a5f]">{{ $value }}</p>
</div>