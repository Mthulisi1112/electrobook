@props(['statistics'])

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-2xl font-bold text-[#1e3a5f]">{{ $statistics['total_bookings'] }}</p>
        <p class="text-xs text-gray-500">Total Bookings</p>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-2xl font-bold text-green-600">{{ $statistics['completed_bookings'] }}</p>
        <p class="text-xs text-gray-500">Completed Jobs</p>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-2xl font-bold text-amber-600">{{ number_format($statistics['average_rating'], 1) }}</p>
        <p class="text-xs text-gray-500">Average Rating</p>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4 text-center">
        <p class="text-2xl font-bold text-[#3b82f6]">{{ $statistics['available_electricians'] }}</p>
        <p class="text-xs text-gray-500">Available Electricians</p>
    </div>
</div>