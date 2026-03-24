@props(['href', 'title', 'description', 'icon', 'color' => 'blue'])

@php
$colors = [
    'blue' => 'bg-blue-100 text-blue-600',
    'green' => 'bg-green-100 text-green-600',
    'amber' => 'bg-amber-100 text-amber-600',
    'purple' => 'bg-purple-100 text-purple-600',
];

$hoverColors = [
    'blue' => 'hover:border-[#3b82f6] hover:bg-blue-50',
    'green' => 'hover:border-green-600 hover:bg-green-50',
    'amber' => 'hover:border-amber-600 hover:bg-amber-50',
    'purple' => 'hover:border-purple-600 hover:bg-purple-50',
];
@endphp

<a href="{{ $href }}" 
   class="flex items-center p-4 border border-gray-200 rounded-lg {{ $hoverColors[$color] }} transition group">
    <div class="p-2 {{ $colors[$color] }} rounded-lg mr-3 group-hover:scale-110 transition">
        {!! $icon !!}
    </div>
    <div>
        <h3 class="font-semibold text-gray-900">{{ $title }}</h3>
        <p class="text-sm text-gray-500">{{ $description }}</p>
    </div>
</a>