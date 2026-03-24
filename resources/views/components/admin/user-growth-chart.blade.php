@props(['growth'])

<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">User Growth (Last 6 Months)</h2>
    
    <div class="space-y-4">
        @foreach($growth as $data)
            @php
                $maxCount = collect($growth)->max('count');
                $percentage = $maxCount > 0 ? ($data['count'] / $maxCount) * 100 : 0;
            @endphp
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">{{ $data['month'] }}</span>
                    <span class="font-semibold text-[#1e3a5f]">{{ $data['count'] }} users</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="h-2 rounded-full bg-green-500" style="width: {{ $percentage }}%"></div>
                </div>
            </div>
        @endforeach
    </div>

    @if($growth->isNotEmpty())
        <div class="mt-4 pt-4 border-t border-gray-200">
            <div class="flex justify-between text-sm">
                <span class="text-gray-600">Total growth:</span>
                <span class="font-semibold text-green-600">
                    +{{ $growth->last()['count'] - $growth->first()['count'] }} users
                </span>
            </div>
        </div>
    @endif
</div>