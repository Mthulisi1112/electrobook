@extends('layouts.app')

@section('title', 'My Earnings')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('electrician.dashboard') }}" class="text-[#3b82f6] hover:text-[#2563eb] flex items-center mb-4 group">
            <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
            Back to Dashboard
        </a> <!-- Fixed: Added missing closing tag -->
        <h1 class="text-3xl font-bold text-[#1e3a5f]">💰 Earnings Overview</h1>
        <p class="text-gray-600 mt-2">Track your income and payments</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-dollar-sign text-white text-xl"></i>
                </div>
                <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded-full">All time</span>
            </div>
            <p class="text-sm text-gray-500 mb-1">Total Earnings</p>
            <p class="text-2xl font-bold text-[#1e3a5f]">${{ number_format($totalEarnings ?? 0, 2) }}</p>
            <p class="text-xs text-gray-400 mt-2">From completed bookings</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-calendar text-white text-xl"></i>
                </div>
                <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded-full">{{ $currentYear ?? date('Y') }}</span>
            </div>
            <p class="text-sm text-gray-500 mb-1">This Year</p>
            <p class="text-2xl font-bold text-green-600">${{ number_format($yearlyEarnings ?? 0, 2) }}</p>
            @if(isset($earningsGrowth) && $earningsGrowth != 0)
                <p class="text-xs {{ $earningsGrowth > 0 ? 'text-green-500' : 'text-red-500' }} mt-2">
                    <i class="fas {{ $earningsGrowth > 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                    {{ number_format(abs($earningsGrowth), 1) }}% from last month
                </p>
            @else
                <p class="text-xs text-gray-400 mt-2">Payment summary</p>
            @endif
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-clock text-white text-xl"></i>
                </div>
                <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded-full">Pending</span>
            </div>
            <p class="text-sm text-gray-500 mb-1">Pending Payments</p>
            <p class="text-2xl font-bold text-amber-600">${{ number_format($earningsByStatus['confirmed'] ?? 0, 2) }}</p>
            <p class="text-xs text-gray-500 mt-1">From confirmed bookings</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 transform hover:scale-105 transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-receipt text-white text-xl"></i>
                </div>
            </div>
            <p class="text-sm text-gray-500 mb-1">Average per Job</p>
            <p class="text-2xl font-bold text-purple-600">
                ${{ number_format($averagePerBooking ?? 0, 2) }}
            </p>
            <p class="text-xs text-gray-500 mt-1">{{ $completedBookings ?? 0 }} completed jobs</p>
        </div>
    </div>

    <!-- Monthly Earnings Chart -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-[#1e3a5f] text-lg">Monthly Earnings Trend</h3>
                <div class="flex gap-3">
                    <span class="flex items-center text-xs text-gray-500">
                        <span class="w-3 h-3 bg-blue-500 rounded-full mr-1"></span> Earnings
                    </span>
                    <span class="flex items-center text-xs text-gray-500">
                        <span class="w-3 h-3 bg-green-500 rounded-full mr-1"></span> Bookings
                    </span>
                </div>
            </div>
            <div class="h-64">
                <canvas id="earningsChart"></canvas>
            </div>
        </div>

        <!-- Payment Methods Breakdown -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <h3 class="font-semibold text-[#1e3a5f] text-lg mb-4 flex items-center">
                <i class="fas fa-credit-card mr-2 text-[#3b82f6]"></i>
                Payment Methods
            </h3>
            
            @if(isset($paymentMethods) && $paymentMethods->isNotEmpty())
                <div class="space-y-4">
                    @foreach($paymentMethods as $method)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600 capitalize">{{ str_replace('_', ' ', $method->payment_method) }}</span>
                                <span class="font-semibold text-[#1e3a5f]">${{ number_format($method->total, 2) }}</span>
                            </div>
                            <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-[#3b82f6] rounded-full" 
                                     style="width: {{ $totalEarnings > 0 ? ($method->total / $totalEarnings) * 100 : 0 }}%"></div>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">{{ $method->count }} transactions</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4 text-sm">No payment method data available</p>
            @endif
        </div>
    </div>

    <!-- Monthly Breakdown Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <h2 class="text-xl font-semibold text-[#1e3a5f]">📊 Monthly Earnings Breakdown</h2>
        </div>

        @if(isset($monthlyChartData) && count($monthlyChartData) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Month
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Earnings
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Bookings
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Average
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach(array_reverse($monthlyChartData) as $data)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $data['month'] }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-[#3b82f6]">
                                        ${{ number_format($data['earnings'], 2) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600">
                                        {{ $data['bookings'] }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600">
                                        ${{ $data['bookings'] > 0 ? number_format($data['earnings'] / $data['bookings'], 2) : 0 }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-chart-line text-gray-400 text-xl"></i>
                </div>
                <h3 class="text-sm font-medium text-gray-900">No earnings data yet</h3>
                <p class="mt-1 text-sm text-gray-500">Your earnings will appear here once you complete jobs.</p>
            </div>
        @endif
    </div>

    <!-- Upcoming Payments -->
    @if(isset($pendingPayments) && $pendingPayments->isNotEmpty())
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 mb-8">
        <h3 class="font-semibold text-[#1e3a5f] text-lg mb-4 flex items-center">
            <i class="fas fa-clock mr-2 text-amber-500"></i>
            Upcoming Expected Payments
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($pendingPayments as $payment)
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 hover:shadow-md transition">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="font-medium text-gray-900">{{ $payment->client->name }}</p>
                            <p class="text-xs text-gray-500">{{ $payment->service->name }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium bg-amber-100 text-amber-700 rounded-full">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center mt-3">
                        <span class="text-sm text-gray-500">
                            <i class="far fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($payment->booking_date)->format('M j, Y') }}
                        </span>
                        <span class="font-bold text-[#1e3a5f]">${{ number_format($payment->total_amount, 2) }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Recent Transactions -->
    @if(isset($recentEarnings) && $recentEarnings->isNotEmpty())
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <h3 class="font-semibold text-[#1e3a5f] text-lg">Recent Transactions</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($recentEarnings as $earning)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($earning->booking_date)->format('M j, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-br from-[#1e3a5f]/10 to-[#3b82f6]/10 rounded-full flex items-center justify-center mr-2">
                                        <span class="text-xs font-medium text-[#1e3a5f]">
                                            {{ substr($earning->client->name ?? 'C', 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $earning->client->name ?? 'Client' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $earning->service->name ?? 'Service' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">
                                ${{ number_format($earning->total_amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">
                                    Completed
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if(method_exists($recentEarnings, 'links'))
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $recentEarnings->links() }}
        </div>
        @endif
    </div>
    @endif

    <!-- Payment Info -->
    <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
        <div class="flex items-start gap-4">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-info-circle text-blue-600 text-lg"></i>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-blue-900">Payment Information</h3>
                <p class="text-sm text-blue-700 mt-1">
                    Payments are processed within 3-5 business days after job completion. 
                    Pending payments represent confirmed bookings that haven't been completed yet.
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('earningsChart').getContext('2d');
        
        // Safely get chart data
        const chartData = @json($monthlyChartData ?? []);
        const labels = chartData.length > 0 ? chartData.map(item => item.month).reverse() : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
        const earningsData = chartData.length > 0 ? chartData.map(item => item.earnings).reverse() : [0, 0, 0, 0, 0, 0];
        const bookingsData = chartData.length > 0 ? chartData.map(item => item.bookings).reverse() : [0, 0, 0, 0, 0, 0];
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Earnings ($)',
                        data: earningsData,
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderRadius: 8,
                        yAxisID: 'y',
                    },
                    {
                        label: 'Bookings',
                        data: bookingsData,
                        backgroundColor: 'rgba(34, 197, 94, 0.8)',
                        borderRadius: 8,
                        yAxisID: 'y1',
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Earnings ($)'
                        },
                        beginAtZero: true
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Number of Bookings'
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    },
                }
            }
        });
    });
</script>
@endpush
@endsection