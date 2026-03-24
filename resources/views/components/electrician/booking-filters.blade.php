@props(['route' => 'electrician.bookings.index'])

<form method="GET" action="{{ route($route) }}" class="bg-white rounded-lg shadow p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Status Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <!-- From Date -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
            <input type="date" name="from_date" value="{{ request('from_date') }}"
                   class="w-full border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
        </div>

        <!-- To Date -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
            <input type="date" name="to_date" value="{{ request('to_date') }}"
                   class="w-full border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
        </div>

        <!-- Apply Button -->
        <div class="flex items-end">
            <button type="submit" 
                    class="w-full bg-[#3b82f6] text-white px-4 py-2 rounded-lg hover:bg-[#2563eb] transition">
                Apply Filters
            </button>
        </div>
    </div>

    @if(request()->anyFilled(['status', 'from_date', 'to_date']))
        <div class="flex justify-end mt-4">
            <a href="{{ route($route) }}" 
               class="text-sm text-gray-600 hover:text-gray-900">
                Clear Filters
            </a>
        </div>
    @endif
</form>