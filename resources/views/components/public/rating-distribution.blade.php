@props(['ratings'])

<div class="bg-gray-50 rounded-lg p-4">
    <h4 class="font-medium text-gray-900 mb-3">Rating Breakdown</h4>
    
    <div class="space-y-2">
        @foreach([5,4,3,2,1] as $star)
            @php
                $count = $ratings['distribution'][$star] ?? 0;
                $percentage = $ratings['total'] > 0 ? ($count / $ratings['total']) * 100 : 0;
            @endphp
            <div class="flex items-center text-sm">
                <span class="w-12 text-gray-600">{{ $star }} ★</span>
                <div class="flex-1 mx-3">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full bg-amber-400" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                <span class="w-12 text-right text-gray-600">{{ $count }}</span>
            </div>
        @endforeach
    </div>
    
    <div class="mt-3 pt-3 border-t border-gray-200 text-center">
        <p class="text-2xl font-bold text-[#1e3a5f]">{{ $ratings['average'] }}</p>
        <p class="text-xs text-gray-500">out of 5 ({{ $ratings['total'] }} {{ Str::plural('review', $ratings['total']) }})</p>
    </div>
</div>