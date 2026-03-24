@props(['status'])

@php
$classes = match($status) {
    'completed' => 'bg-green-100 text-green-800',
    'cancelled' => 'bg-red-100 text-red-800',
    'confirmed' => 'bg-blue-100 text-blue-800',
    'pending' => 'bg-amber-100 text-amber-800',
    default => 'bg-gray-100 text-gray-800',
};
@endphp

<span class="px-2 py-1 text-xs font-semibold rounded-full {{ $classes }}">
    {{ ucfirst($status) }}
</span>