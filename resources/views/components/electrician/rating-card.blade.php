@props(['averageRating', 'totalReviews'])

<div class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-[#1e3a5f]">Rating</h3>
        <span class="text-3xl font-bold text-[#3b82f6]">{{ number_format($averageRating, 1) }}</span>
    </div>
    <div class="flex items-center">
        <div class="flex text-amber-400 text-xl">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= round($averageRating))
                    ★
                @else
                    ☆
                @endif
            @endfor
        </div>
        <span class="ml-2 text-sm text-gray-600">({{ $totalReviews }} {{ Str::plural('review', $totalReviews) }})</span>
    </div>
</div>