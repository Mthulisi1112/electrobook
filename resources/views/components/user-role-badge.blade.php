@props(['role'])

@php
$classes = match($role) {
    'admin' => 'bg-purple-100 text-purple-800',
    'electrician' => 'bg-green-100 text-green-800',
    'client' => 'bg-blue-100 text-blue-800',
    default => 'bg-gray-100 text-gray-800',
};
@endphp

<span class="px-2 py-1 text-xs font-semibold rounded-full {{ $classes }}">
    {{ ucfirst($role) }}
</span>