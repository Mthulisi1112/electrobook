@props(['type' => 'overview', 'startDate', 'endDate'])

<div class="bg-white rounded-lg shadow p-6 mb-8">
    <form method="GET" action="{{ route('admin.reports') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Report Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Report Type</label>
                <select name="type" class="w-full border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
                    <option value="overview" {{ $type == 'overview' ? 'selected' : '' }}>Overview</option>
                    <option value="bookings" {{ $type == 'bookings' ? 'selected' : '' }}>Bookings Report</option>
                    <option value="revenue" {{ $type == 'revenue' ? 'selected' : '' }}>Revenue Report</option>
                    <option value="electricians" {{ $type == 'electricians' ? 'selected' : '' }}>Electricians Report</option>
                    <option value="users" {{ $type == 'users' ? 'selected' : '' }}>Users Report</option>
                </select>
            </div>

            <!-- Start Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                <input type="date" name="start_date" value="{{ $startDate }}"
                       class="w-full border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
            </div>

            <!-- End Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                <input type="date" name="end_date" value="{{ $endDate }}"
                       class="w-full border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
            </div>

            <!-- Apply Button -->
            <div class="flex items-end">
                <button type="submit" 
                        class="w-full bg-[#3b82f6] text-white px-4 py-2 rounded-lg hover:bg-[#2563eb] transition">
                    Generate Report
                </button>
            </div>
        </div>
    </form>
</div>