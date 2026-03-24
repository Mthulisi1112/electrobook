@props(['title', 'subtitle'])

<div class="mb-8">
    <h1 class="text-3xl font-bold text-[#1e3a5f]">{{ $title }}</h1>
    @if($subtitle)
        <p class="text-gray-600 mt-2">{{ $subtitle }}</p>
    @endif
</div>