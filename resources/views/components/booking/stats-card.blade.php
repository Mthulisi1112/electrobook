@props(['stats'])

<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-2xl font-bold text-[#1e3a5f]">{{ $stats['total'] }}</p>
        <p class="text-xs text-gray-500">Total</p>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-2xl font-bold text-amber-600">{{ $stats['pending'] }}</p>
        <p class="text-xs text-gray-500">Pending</p>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-2xl font-bold text-blue-600">{{ $stats['confirmed'] }}</p>
        <p class="text-xs text-gray-500">Confirmed</p>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-2xl font-bold text-green-600">{{ $stats['completed'] }}</p>
        <p class="text-xs text-gray-500">Completed</p>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-2xl font-bold text-red-600">{{ $stats['cancelled'] }}</p>
        <p class="text-xs text-gray-500">Cancelled</p>
    </div>
</div>