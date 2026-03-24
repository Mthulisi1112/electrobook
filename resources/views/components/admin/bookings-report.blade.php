@props(['data'])

<div class="space-y-8">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-500">Total Bookings</p>
            <p class="text-3xl font-bold text-[#1e3a5f]">{{ $data['total'] }}</p>
        </div>
    </div>

    <!-- Bookings by Status -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-[#1e3a5f] mb-4">Bookings by Status</h3>
        <div class="space-y-4">
            @foreach($data['by_status'] as $status)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="capitalize">{{ $status->status }}</span>
                        <span class="font-semibold">{{ $status->total }}</span>
                    </div>
                    <x-progress-bar :percentage="($status->total / $data['total']) * 100" 
                                    :color="match($status->status) {
                                        'completed' => 'green',
                                        'confirmed' => 'blue',
                                        'pending' => 'amber',
                                        'cancelled' => 'red',
                                        default => 'gray'
                                    }" />
                </div>
            @endforeach
        </div>
    </div>

    <!-- Popular Services -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-[#1e3a5f] mb-4">Most Popular Services</h3>
        <div class="space-y-4">
            @foreach($data['by_service'] as $service)
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">{{ $service->name }}</span>
                    <span class="font-semibold text-[#3b82f6]">{{ $service->total }} bookings</span>
                </div>
            @endforeach
        </div>
    </div>
</div>