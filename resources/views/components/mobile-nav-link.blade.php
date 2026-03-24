@props(['active' => false, 'href' => '#'])

@php
$classes = ($active ?? false)
    ? 'bg-[#3b82f6] text-white block px-3 py-2 rounded-md text-base font-medium'
    : 'text-gray-600 hover:bg-gray-50 block px-3 py-2 rounded-md text-base font-medium';
@endphp

<a {{ $attributes->merge(['href' => $href, 'class' => $classes]) }}>
    {{ $slot }}
</a>