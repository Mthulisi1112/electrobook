@props(['rating' => 0, 'size' => 'small'])

@php
$sizes = [
    'small' => 'w-3 h-3',
    'medium' => 'w-4 h-4',
    'large' => 'w-5 h-5',
];
$starSize = $sizes[$size] ?? $sizes['small'];
@endphp

<div class="flex text-amber-400">
    @for($i = 1; $i <= 5; $i++)
        @if($i <= round($rating))
            <svg class="{{ $starSize }} fill-current" viewBox="0 0 20 20">
                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
            </svg>
        @else
            <svg class="{{ $starSize }} fill-current text-gray-300" viewBox="0 0 20 20">
                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
            </svg>
        @endif
    @endfor
</div>