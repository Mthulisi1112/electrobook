@extends('layouts.app')

@section('title', $electrician->business_name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex justify-between items-start mb-8">
        <div>
            <a href="{{ route('admin.electricians.index') }}" class="text-[#3b82f6] hover:text-[#2563eb] flex items-center mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Electricians
            </a>
            <h1 class="text-3xl font-bold text-[#1e3a5f]">{{ $electrician->business_name }}</h1>
            <p class="text-gray-600 mt-2">{{ $electrician->user->name }}</p>
        </div>
        <div class="flex space-x-3">
            @if(!$electrician->is_verified)
                <form method="POST" action="{{ route('admin.electricians.verify', $electrician) }}">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Verify
                    </button>
                </form>
            @endif
            <a href="{{ route('admin.electricians.edit', $electrician) }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
        </div>
    </div>

    <!-- Status Banner -->
    @if(!$electrician->is_verified)
        <div class="bg-amber-50 border-l-4 border-amber-400 p-4 mb-8">
            <div class="flex">
                <div class="shrink-0">
                    <svg class="h-5 w-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-amber-700">
                        This electrician is pending verification. 
                        <a href="#" onclick="event.preventDefault(); document.getElementById('verify-form').submit();" class="font-medium underline text-amber-700 hover:text-amber-600">
                            Click here to verify now.
                        </a>
                    </p>
                </div>
            </div>
        </div>
        <form id="verify-form" method="POST" action="{{ route('admin.electricians.verify', $electrician) }}" class="hidden">
            @csrf
        </form>
    @endif

    @if($electrician->is_suspended ?? false)
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-8">
            <div class="flex">
                <div class="shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">
                        This electrician is suspended. Reason: {{ $electrician->suspension_reason }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-center">
                <p class="text-3xl font-bold text-[#1e3a5f]">{{ $stats['total_bookings'] }}</p>
                <p class="text-sm text-gray-500">Total Bookings</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-center">
                <p class="text-3xl font-bold text-green-600">{{ $stats['completed_bookings'] }}</p>
                <p class="text-sm text-gray-500">Completed</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-center">
                <p class="text-3xl font-bold text-[#3b82f6]">${{ number_format($stats['total_earnings'], 0) }}</p>
                <p class="text-sm text-gray-500">Total Earnings</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-center">
                <p class="text-3xl font-bold text-amber-600">{{ number_format($stats['average_rating'], 1) }}</p>
                <p class="text-sm text-gray-500">Avg Rating ({{ $stats['total_reviews'] }} reviews)</p>
            </div>
        </div>
    </div>

    <!-- Profile Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Business Info -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Business Information</h2>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Business Name</p>
                        <p class="font-medium">{{ $electrician->business_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">License Number</p>
                        <p class="font-medium">{{ $electrician->license_number ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Years Experience</p>
                        <p class="font-medium">{{ $electrician->years_experience ?? 0 }} years</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Hourly Rate</p>
                        <p class="font-medium text-[#3b82f6]">${{ number_format($electrician->hourly_rate, 2) }}/hr</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-sm text-gray-500">Bio</p>
                        <p class="font-medium">{{ $electrician->bio ?? 'No bio provided.' }}</p>
                    </div>
                    @if($electrician->service_areas)
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500 mb-2">Service Areas</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($electrician->service_areas as $area)
                                    <span class="px-3 py-1 bg-gray-100 rounded-full text-sm text-gray-700">{{ $area }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="bg-white rounded-lg shadow p-6 mt-6">
                <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Recent Bookings</h2>
                
                @if($electrician->bookings->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($electrician->bookings as $booking)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium">{{ $booking->service->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $booking->booking_date->format('M d, Y') }} at {{ $booking->start_time->format('g:i A') }}</p>
                                </div>
                                <x-booking-status-badge :status="$booking->status" />
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No bookings yet</p>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Contact Info -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Contact Information</h2>
                
                <div class="space-y-3">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-gray-700">{{ $electrician->user->email }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span class="text-gray-700">{{ $electrician->phone }}</span>
                    </div>
                    <div class="pt-3 border-t">
                        <p class="text-sm text-gray-500">Member since</p>
                        <p class="font-medium">{{ $electrician->created_at->format('F d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Services -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Services Offered</h2>
                
                @if($electrician->services->isNotEmpty())
                    <div class="space-y-2">
                        @foreach($electrician->services as $service)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700">{{ $service->name }}</span>
                                @if($service->pivot && $service->pivot->price)
                                    <span class="text-sm font-semibold text-[#3b82f6]">${{ number_format($service->pivot->price, 2) }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No services added</p>
                @endif
            </div>

            <!-- Danger Zone -->
            @if($electrician->is_verified)
            <div class="bg-white rounded-lg shadow p-6 mt-6 border-2 border-red-200">
                <h2 class="text-xl font-semibold text-red-600 mb-4">Danger Zone</h2>
                
                <div class="space-y-3">
                    @if(!($electrician->is_suspended ?? false))
                        <button onclick="showSuspendModal()" 
                                class="w-full px-4 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700 transition">
                            Suspend Electrician
                        </button>
                    @else
                        <form method="POST" action="{{ route('admin.electricians.reinstate', $electrician) }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                                Reinstate Electrician
                            </button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('admin.electricians.destroy', $electrician) }}"
                          onsubmit="return confirm('Are you sure you want to delete this electrician? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition"
                                {{ $electrician->bookings()->exists() ? 'disabled' : '' }}>
                            Delete Electrician
                        </button>
                    </form>
                    @if($electrician->bookings()->exists())
                        <p class="text-xs text-red-600 mt-2">Cannot delete - has existing bookings</p>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Suspend Modal -->
<div id="suspendModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h3 class="text-lg font-semibold text-[#1e3a5f] mb-4">Suspend Electrician</h3>
        <form method="POST" action="{{ route('admin.electricians.suspend', $electrician) }}">
            @csrf
            <div class="mb-4">
                <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Reason for Suspension</label>
                <textarea name="reason" id="reason" rows="3" required
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                          placeholder="Please provide a reason for suspending this electrician..."></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="hideSuspendModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Suspend
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showSuspendModal() {
    document.getElementById('suspendModal').classList.remove('hidden');
    document.getElementById('suspendModal').classList.add('flex');
}

function hideSuspendModal() {
    document.getElementById('suspendModal').classList.add('hidden');
    document.getElementById('suspendModal').classList.remove('flex');
}

// Close modal when clicking outside
document.getElementById('suspendModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideSuspendModal();
    }
});
</script>
<!-- Your existing content ... -->

<!-- Debugging Script - Remove after fixing -->
<script>
function interactiveDebugger() {
    return {
        showDebug: false,
        lastClickTime: null,
        lastTarget: '',
        lastClasses: '',
        lastLink: null,
        
        init() {
            console.log('🔍 Interactive Debugger initialized');
        },
        
        handleClick(event) {
            const target = event.target;
            const link = target.closest('a');
            
            this.lastClickTime = new Date().toLocaleTimeString();
            this.lastTarget = target.tagName;
            this.lastClasses = target.className || 'none';
            
            if (link) {
                this.lastLink = link.href;
                console.log('🔗 Link clicked:', link.href);
            } else {
                this.lastLink = null;
                console.log('🖱️ Element clicked:', target.tagName);
            }
            
            this.flashElement(target);
        },
        
        flashElement(element) {
            const originalOutline = element.style.outline;
            element.style.outline = '2px solid #3b82f6';
            element.style.outlineOffset = '2px';
            
            setTimeout(() => {
                element.style.outline = originalOutline;
            }, 500);
        }
    }
}
</script>

<!-- Wrap your content with the debugger -->
<div x-data="interactiveDebugger()" 
     @click="handleClick($event)"
     class="relative">
    
    <!-- Your existing content goes here - copy everything inside your content section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- ... all your existing content ... -->
    </div>
    
    <!-- Debug Panel -->
    <div x-show="showDebug" 
         class="fixed bottom-4 right-4 bg-black text-white p-4 rounded-lg shadow-xl z-50 max-w-md"
         x-transition
         @click.away="showDebug = false">
        <div class="flex justify-between items-center mb-2">
            <h3 class="font-bold">Click Debugger</h3>
            <button @click="showDebug = false" class="text-gray-400 hover:text-white">✕</button>
        </div>
        <div class="space-y-2 text-sm">
            <p><span class="text-gray-400">Last click:</span> <span x-text="lastClickTime || 'None'"></span></p>
            <p><span class="text-gray-400">Target:</span> <span x-text="lastTarget"></span></p>
            <p><span class="text-gray-400">Classes:</span> <span x-text="lastClasses"></span></p>
            <template x-if="lastLink">
                <div>
                    <p><span class="text-gray-400">Link:</span> <span x-text="lastLink" class="text-blue-400 break-all"></span></p>
                </div>
            </template>
        </div>
    </div>
    
    <!-- Floating debug button -->
    <button @click="showDebug = true" 
            x-show="!showDebug"
            class="fixed bottom-4 right-4 bg-[#3b82f6] text-white p-3 rounded-full shadow-lg z-50 hover:bg-[#2563eb]">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
        </svg>
    </button>
</div>

@endsection
