@extends('layouts.app')

@section('title', 'Booking #' . $booking->booking_number)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('bookings.index') }}" class="text-[#3b82f6] hover:text-[#2563eb] flex items-center mb-4">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Bookings
        </a>

        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-[#1e3a5f]">Booking #{{ $booking->booking_number }}</h1>
                <div class="flex items-center mt-2">
                    <x-booking.status-badge :status="$booking->status" />
                    <span class="ml-3 text-sm text-gray-500">
                        Booked on {{ $booking->created_at->format('M d, Y g:i A') }}
                    </span>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex space-x-3">
                @if(auth()->user()->isElectrician() && $booking->status === 'pending')
                    <form method="POST" action="{{ route('bookings.confirm', $booking) }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Confirm Booking
                        </button>
                    </form>
                @endif

                @if(auth()->user()->isElectrician() && $booking->status === 'confirmed')
                    <form method="POST" action="{{ route('bookings.complete', $booking) }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Mark Complete
                        </button>
                    </form>
                @endif

                @if(in_array($booking->status, ['pending', 'confirmed']) && 
                    (auth()->user()->isClient() || auth()->user()->isElectrician() || auth()->user()->isAdmin()))
                    <button onclick="showCancelModal()" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel Booking
                    </button>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Booking Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Booking Details</h2>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Service</p>
                        <p class="font-medium">{{ $booking->service->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Date</p>
                        <p class="font-medium">{{ $booking->booking_date->format('l, F j, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Start Time</p>
                        <p class="font-medium">{{ $booking->start_time->format('g:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">End Time</p>
                        <p class="font-medium">{{ $booking->end_time->format('g:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Duration</p>
                        <p class="font-medium">{{ $booking->start_time->diffInHours($booking->end_time) }} hours</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Amount</p>
                        <p class="font-medium text-[#3b82f6]">${{ number_format($booking->total_amount, 2) }}</p>
                    </div>
                </div>

                @if($booking->description)
                    <div class="mt-4 pt-4 border-t">
                        <p class="text-sm text-gray-500 mb-2">Job Description</p>
                        <p class="text-gray-700">{{ $booking->description }}</p>
                    </div>
                @endif
            </div>

            <!-- Location Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Service Location</h2>
                
                <div class="space-y-2">
                    <p class="text-gray-700">{{ $booking->address }}</p>
                    <p class="text-gray-700">{{ $booking->city }}, {{ $booking->postal_code }}</p>
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Booking Timeline</h2>
            
            <div class="space-y-4">
                @php $items = []; @endphp
                
                <!-- Created item -->
                @php $items[] = [
                    'status' => 'created',
                    'date' => $booking->created_at->format('M d, Y g:i A'),
                    'description' => 'Booking created',
                    'active' => true
                ]; @endphp
                
                @if($booking->status === 'confirmed' || $booking->status === 'completed')
                    @php $items[] = [
                        'status' => 'confirmed',
                        'date' => $booking->updated_at->format('M d, Y g:i A'),
                        'description' => 'Booking confirmed by electrician',
                        'active' => true
                    ]; @endphp
                @endif

                @if($booking->status === 'completed')
                    @php $items[] = [
                        'status' => 'completed',
                        'date' => $booking->updated_at->format('M d, Y g:i A'),
                        'description' => 'Service completed',
                        'active' => true
                    ]; @endphp
                @endif

                @if($booking->status === 'cancelled')
                    @php $items[] = [
                        'status' => 'cancelled',
                        'date' => $booking->cancelled_at->format('M d, Y g:i A'),
                        'description' => 'Booking cancelled',
                        'active' => true
                    ]; @endphp
                @endif
                
                @foreach($items as $index => $item)
                    <x-booking.timeline-item 
                        status="{{ $item['status'] }}"
                        date="{{ $item['date'] }}"
                        description="{{ $item['description'] }}"
                        :active="$item['active']"
                        :last="$loop->last"
                    />
                @endforeach
                
                @if($booking->status === 'cancelled')
                    <p class="text-sm text-gray-600 mt-2">
                        <span class="font-medium">Reason:</span> {{ $booking->cancellation_reason }}
                    </p>
                @endif
            </div>
</div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Client Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Client Information</h2>
                
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-[#1e3a5f] flex items-center justify-center text-white text-lg font-bold">
                        {{ substr($booking->client->name, 0, 1) }}
                    </div>
                    <div class="ml-3">
                        <p class="font-medium text-gray-900">{{ $booking->client->name }}</p>
                        <p class="text-sm text-gray-500">{{ $booking->client->email }}</p>
                    </div>
                </div>

                @if($booking->client->phone)
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        {{ $booking->client->phone }}
                    </div>
                @endif

                <div class="mt-4 pt-4 border-t">
                    <p class="text-sm text-gray-500">Member since</p>
                    <p class="font-medium">{{ $booking->client->created_at->format('F Y') }}</p>
                </div>
            </div>

            <!-- Electrician Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Electrician Information</h2>
                
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-[#1e3a5f] flex items-center justify-center text-white text-lg font-bold">
                        {{ substr($booking->electrician->business_name, 0, 1) }}
                    </div>
                    <div class="ml-3">
                        <p class="font-medium text-gray-900">{{ $booking->electrician->business_name }}</p>
                        <p class="text-sm text-gray-500">{{ $booking->electrician->user->email }}</p>
                    </div>
                </div>

                @if($booking->electrician->phone)
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        {{ $booking->electrician->phone }}
                    </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('electricians.show', $booking->electrician) }}" 
                       class="text-sm text-[#3b82f6] hover:text-[#2563eb]">
                        View Electrician Profile →
                    </a>
                </div>
            </div>

            <!-- Review Section -->
            @if($canReview)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Leave a Review</h2>
                    
                    <form method="POST" action="{{ route('reviews.store', $booking) }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                            <div class="flex space-x-2" x-data="{ rating: 0 }">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" 
                                            @click="rating = {{ $i }}"
                                            class="focus:outline-none">
                                        <svg class="w-8 h-8" :class="rating >= {{ $i }} ? 'text-amber-400' : 'text-gray-300'" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </button>
                                @endfor
                                <input type="hidden" name="rating" x-model="rating">
                            </div>
                            @error('rating')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">
                                Your Review
                            </label>
                            <textarea name="comment" 
                                      id="comment" 
                                      rows="4"
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6]"
                                      placeholder="Share your experience with this electrician...">{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" 
                                class="w-full bg-[#3b82f6] text-white px-4 py-2 rounded-md hover:bg-[#2563eb] transition">
                            Submit Review
                        </button>
                    </form>
                </div>
            @elseif($booking->review)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Your Review</h2>
                    
                    <div class="flex items-center mb-2">
                        <div class="flex text-amber-400">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $booking->review->rating)
                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 fill-current text-gray-300" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                    </div>
                    
                    @if($booking->review->comment)
                        <p class="text-gray-700">"{{ $booking->review->comment }}"</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Cancel Modal -->
<div id="cancelModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h3 class="text-lg font-semibold text-red-600 mb-4">Cancel Booking</h3>
        <form method="POST" action="{{ route('bookings.cancel', $booking) }}" id="cancelForm">
            @csrf
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-4">
                    Are you sure you want to cancel booking #{{ $booking->booking_number }}?
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
function showCancelModal() {
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