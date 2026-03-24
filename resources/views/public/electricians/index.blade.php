@extends('layouts.app')

@section('title', 'Find Electricians - ElectroBook')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Hero Section -->
    <div class="bg-gradient-to-b from-gray-50 to-white border-b border-gray-200 -mt-8 mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">
                    Find trusted electricians in your area
                </h1>
                <p class="text-lg text-gray-600 mb-6">
                    Browse verified professionals ready to help with installations, repairs, and maintenance.
                </p>
                
                <!-- Quick Search Bar -->
                <div class="bg-white p-1 rounded-xl shadow-sm border border-gray-200 max-w-xl mx-auto">
                    <div class="flex">
                        <input type="text" 
                               placeholder="Search by name or service..." 
                               class="flex-1 px-4 py-2.5 border-0 focus:outline-none text-gray-700 rounded-l-lg"
                               value="{{ request('search') }}">
                        <button class="px-6 py-2.5 bg-[#1e3a5f] text-white font-medium rounded-r-lg hover:bg-[#2b4c7c] transition">
                            Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white border border-gray-200 rounded-xl p-6 text-center hover:shadow-md transition">
            <div class="w-12 h-12 bg-[#1e3a5f]/5 rounded-xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-[#1e3a5f]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-1">{{ $statistics['total'] }}</p>
            <p class="text-sm text-gray-500">Verified Electricians</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-6 text-center hover:shadow-md transition">
            <div class="w-12 h-12 bg-[#1e3a5f]/5 rounded-xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-[#1e3a5f]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($statistics['avg_rating'],1) }}</p>
            <p class="text-sm text-gray-500">Average Rating</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-6 text-center hover:shadow-md transition">
            <div class="w-12 h-12 bg-[#1e3a5f]/5 rounded-xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-[#1e3a5f]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
            </div>
            <p class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($statistics['total_reviews']) }}</p>
            <p class="text-sm text-gray-500">Customer Reviews</p>
        </div>
    </div>

    <!-- Filters Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <button class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
            </svg>
            Filter
        </button>
        
        <!-- Active Filters -->
        @if(request()->anyFilled(['search','service','area','min_rating','max_price','available_now']))
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-sm text-gray-500">Active filters:</span>
                
                @if(request('search'))
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-gray-100 rounded-full text-xs">
                        "{{ request('search') }}"
                        <a href="{{ route('electricians.index', array_merge(request()->except('search'), ['page' => null])) }}" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                @endif
                
                @if(request('service'))
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-gray-100 rounded-full text-xs">
                        Service: {{ $services->firstWhere('id', request('service'))->name ?? '' }}
                        <a href="{{ route('electricians.index', array_merge(request()->except('service'), ['page' => null])) }}" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    </span>
                @endif
            </div>
        @endif

        <p class="text-sm text-gray-500">{{ $electricians->total() }} electricians available</p>
    </div>

    <!-- Electricians Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($electricians as $electrician)
            <x-public.electrician-card :electrician="$electrician" />
        @empty
            <!-- Empty State -->
            <div class="col-span-3 text-center py-16 bg-gray-50 rounded-xl">
                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No electricians found</h3>
                <p class="text-gray-500 mb-4">Try adjusting your filters to see more results.</p>
                <a href="{{ route('electricians.index') }}" class="text-[#1e3a5f] font-medium hover:text-[#2b4c7c]">
                    Clear all filters
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($electricians->hasPages())
        <div class="mt-10 flex justify-center">
            {{ $electricians->withQueryString()->links('pagination::tailwind') }}
        </div>
    @endif

    <!-- Help Section -->
    <div class="mt-16 bg-gray-50 rounded-xl p-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-[#1e3a5f]/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#1e3a5f]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2M3 12h18m-6 8h6a2 2 0 002-2V7a2 2 0 00-2-2h-6m-6 8h.01M7 20h10"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Need help choosing an electrician?</h3>
                    <p class="text-gray-600">Our team is here to help you find the perfect professional for your project.</p>
                </div>
            </div>
            <a href="{{ route('contact') }}" class="inline-flex items-center px-5 py-2.5 bg-[#1e3a5f] text-white font-medium rounded-lg hover:bg-[#2b4c7c] transition">
                Contact Support
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</div>
@endsection