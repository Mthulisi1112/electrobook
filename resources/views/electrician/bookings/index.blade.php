@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-[#1e3a5f]">My Bookings</h1>
        <p class="text-gray-600 mt-2">View and manage all your booking requests</p>
    </div>

    <!-- Stats -->
    <x-electrician.booking-stats :stats="$stats" />

    <!-- Filters -->
    <x-electrician.booking-filters />

    <!-- Quick Actions Info -->
    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-8">
        <div class="flex">
            <div class="shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700">
                    <strong>Quick tip:</strong> 
                    @if($stats['pending'] > 0)
                        You have <span class="font-semibold">{{ $stats['pending'] }} pending {{ Str::plural('booking', $stats['pending']) }}</span> 
                        that need your attention. Review and confirm them promptly.
                    @else
                        You have no pending bookings at the moment. Keep your availability updated to receive more bookings.
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Results count -->
    <div class="mb-4">
        <p class="text-sm text-gray-600">
            Showing {{ $bookings->firstItem() ?? 0 }} - {{ $bookings->lastItem() ?? 0 }} of {{ $bookings->total() }} bookings
        </p>
    </div>

    <!-- Bookings Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Client
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Service
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date & Time
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Amount
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($bookings as $booking)
                    <x-electrician.booking-table-row :booking="$booking" />
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No bookings found</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if(request()->anyFilled(['status', 'from_date', 'to_date']))
                                    No bookings match your filter criteria. Try adjusting your filters.
                                @else
                                    You don't have any bookings yet. They will appear here when clients book your services.
                                @endif
                            </p>
                            @if(request()->anyFilled(['status', 'from_date', 'to_date']))
                                <div class="mt-6">
                                    <a href="{{ route('electrician.bookings.index') }}" 
                                       class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        Clear Filters
                                    </a>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $bookings->withQueryString()->links() }}
    </div>
</div>

<!-- Cancel Modal -->
<div id="cancelModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h3 class="text-lg font-semibold text-red-600 mb-4">Cancel Booking</h3>
        <form method="POST" action="" id="cancelForm">
            @csrf
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-4">
                    Are you sure you want to cancel booking <span id="bookingNumber" class="font-semibold"></span>?
                </p>
                <label for="cancellation_reason" class="block text-sm font-medium text-gray-700 mb-1">
                    Reason for cancellation *
                </label>
                <textarea name="cancellation_reason" 
                          id="cancellation_reason" 
                          rows="3" 
                          required
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                          placeholder="Please provide a reason for cancelling this booking..."></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="hideCancelModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Confirm Cancellation
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showCancelModal(bookingId, bookingNumber) {
    document.getElementById('cancelForm').action = `{{ url('electrician/bookings') }}/${bookingId}/cancel`;
    document.getElementById('bookingNumber').textContent = bookingNumber;
    document.getElementById('cancelModal').classList.remove('hidden');
    document.getElementById('cancelModal').classList.add('flex');
}

function hideCancelModal() {
    document.getElementById('cancelModal').classList.add('hidden');
    document.getElementById('cancelModal').classList.remove('flex');
    document.getElementById('cancellation_reason').value = '';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('cancelModal');
    if (event.target === modal) {
        hideCancelModal();
    }
}
</script>
@endsection