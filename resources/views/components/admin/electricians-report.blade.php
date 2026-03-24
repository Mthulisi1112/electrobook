@props(['data'])

<div class="space-y-8">
    <!-- Electrician Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-500">Total Electricians</p>
            <p class="text-3xl font-bold text-[#1e3a5f]">{{ $data['total'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-500">Verified</p>
            <p class="text-3xl font-bold text-green-600">{{ $data['verified'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-500">New (Selected Period)</p>
            <p class="text-3xl font-bold text-[#3b82f6]">{{ $data['new'] }}</p>
        </div>
    </div>

    <!-- Top Performing Electricians -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-[#1e3a5f]">Top Performing Electricians</h3>
        </div>
        <div class="divide-y divide-gray-200">
            @foreach($data['top'] as $index => $electrician)
                <div class="p-4 hover:bg-gray-50">
                    <div class="flex items-center">
                        <div class="shrink-0 w-8 text-lg font-bold text-gray-400">#{{ $index + 1 }}</div>
                        <div class="shrink-0 ml-2">
                            <div class="h-10 w-10 rounded-full bg-[#1e3a5f] flex items-center justify-center text-white font-bold">
                                {{ substr($electrician->business_name, 0, 1) }}
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $electrician->business_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $electrician->user->name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-[#3b82f6]">{{ $electrician->bookings_count }} bookings</p>
                                    @if($electrician->reviews_avg_rating)
                                        <div class="flex items-center mt-1">
                                            <x-rating-stars :rating="$electrician->reviews_avg_rating" size="small" />
                                            <span class="ml-1 text-xs text-gray-500">({{ number_format($electrician->reviews_avg_rating, 1) }})</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>