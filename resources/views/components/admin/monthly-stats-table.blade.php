@props(['monthlyData', 'year'])

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-[#1e3a5f]">Monthly Performance - {{ $year }}</h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Month
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Total Bookings
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Completed
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Completion Rate
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Revenue
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($monthlyData as $data)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $data['month'] }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $data['bookings'] }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $data['completed'] }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $rate = $data['bookings'] > 0 ? round(($data['completed'] / $data['bookings']) * 100, 1) : 0;
                            @endphp
                            <div class="flex items-center">
                                <span class="text-sm text-gray-900 mr-2">{{ $rate }}%</span>
                                <div class="w-16 bg-gray-200 rounded-full h-2">
                                    <div class="h-2 rounded-full bg-green-500" style="width: {{ $rate }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-[#3b82f6]">
                                ${{ number_format($data['revenue'], 2) }}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50">
                @php
                    $totalBookings = collect($monthlyData)->sum('bookings');
                    $totalCompleted = collect($monthlyData)->sum('completed');
                    $totalRevenue = collect($monthlyData)->sum('revenue');
                    $overallRate = $totalBookings > 0 ? round(($totalCompleted / $totalBookings) * 100, 1) : 0;
                @endphp
                <tr>
                    <td class="px-6 py-3 text-sm font-semibold text-gray-900">Total</td>
                    <td class="px-6 py-3 text-sm font-semibold text-gray-900">{{ $totalBookings }}</td>
                    <td class="px-6 py-3 text-sm font-semibold text-gray-900">{{ $totalCompleted }}</td>
                    <td class="px-6 py-3 text-sm font-semibold text-gray-900">{{ $overallRate }}%</td>
                    <td class="px-6 py-3 text-sm font-semibold text-[#3b82f6]">${{ number_format($totalRevenue, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>