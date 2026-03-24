@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#1e3a5f]">
                @if(auth()->user()->isAdmin())
                    All Bookings
                @elseif(auth()->user()->isElectrician())
                    Booking Requests
                @else
                    My Bookings
                @endif
            </h1>
            <p class="text-gray-600 mt-2">
                @if(auth()->user()->isAdmin())
                    Manage all bookings across the platform
                @elseif(auth()->user()->isElectrician())
                    View and manage your booking requests
                @else
                    Track and manage your service bookings
                @endif
            </p>
        </div>
        
        @if(auth()->user()->isClient())
            <a href="{{ route('bookings.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-[#3b82f6] text-white rounded-md hover:bg-[#2563eb] transition">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Booking
            </a>
        @endif
    </div>

    <!-- Stats -->
    <x-booking.stats-card :stats="$stats" />

    <!-- Filters -->
    <x-booking.filters />

    <!-- Results Count -->
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
                        Booking #
                    </th>
                    
                    @if(auth()->user()->isAdmin())
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Client
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Electrician
                        </th>
                    @elseif(auth()->user()->isElectrician())
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Client
                        </th>
                    @else
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Electrician
                        </th>
                    @endif

                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Service
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date
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
                    <x-booking.table-row 
                        :booking="$booking" 
                        :userRole="auth()->user()->role"
                    />
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No bookings found</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if(request()->anyFilled(['status', 'from_date', 'to_date']))
                                    No bookings match your filter criteria.
                                @elseif(auth()->user()->isClient())
                                    You haven't made any bookings yet.
                                @elseif(auth()->user()->isElectrician())
                                    You haven't received any booking requests yet.
                                @else
                                    No bookings have been made yet.
                                @endif
                            </p>
                            @if(auth()->user()->isClient())
                                <div class="mt-6">
                                    <a href="{{ route('bookings.create') }}" 
                                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#3b82f6] hover:bg-[#2563eb]">
                                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Book a Service
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
                    Close
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
    document.getElementById('cancelForm').action = `{{ url('bookings') }}/${bookingId}/cancel`;
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