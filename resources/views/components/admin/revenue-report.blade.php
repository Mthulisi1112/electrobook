@props(['data'])

<div class="space-y-8">
    <!-- Revenue Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-500">Total Revenue</p>
            <p class="text-3xl font-bold text-[#1e3a5f]">${{ number_format($data['total'], 2) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-500">Average Booking Value</p>
            <p class="text-3xl font-bold text-[#1e3a5f]">${{ number_format($data['average'], 2) }}</p>
        </div>
    </div>

    <!-- Monthly Revenue Breakdown -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-[#1e3a5f] mb-4">Monthly Revenue</h3>
        <div class="space-y-4">
            @foreach($data['monthly'] as $month)
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">{{ $month->month }}</span>
                    <span class="font-semibold text-[#3b82f6]">${{ number_format($month->total, 2) }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>