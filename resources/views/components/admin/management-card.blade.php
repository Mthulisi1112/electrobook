@props(['title', 'description', 'route', 'icon', 'color' => 'blue'])

@php
$colors = [
    'blue' => 'bg-blue-100 text-blue-600',
    'green' => 'bg-green-100 text-green-600',
    'purple' => 'bg-purple-100 text-purple-600',
    'amber' => 'bg-amber-100 text-amber-600',
    'red' => 'bg-red-100 text-red-600',
];
@endphp

<a href="{{ $route }}" 
   class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition group">
    <div class="flex items-center mb-4">
        <div class="p-3 {{ $colors[$color] }} rounded-lg">
            {!! $icon !!}
        </div>
        <h3 class="ml-4 text-xl font-semibold text-[#1e3a5f] group-hover:text-[#3b82f6] transition">
            {{ $title }}
        </h3>
    </div>
    <p class="text-gray-600 mb-4">{{ $description }}</p>
    <span class="text-[#3b82f6] group-hover:underline">Manage →</span>
</a>