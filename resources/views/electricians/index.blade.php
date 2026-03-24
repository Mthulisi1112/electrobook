@extends('layouts.app')

@section('title', 'Find Electricians')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-[#1e3a5f]">Find an Electrician</h1>
        <p class="text-gray-600 mt-2">Browse our verified professional electricians in your area</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow mb-8">
        <form method="GET" action="{{ route('electricians.index') }}" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Name or business..."
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6]">
                </div>

                <!-- Service Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Service</label>
                    <select name="service" class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6]">
                        <option value="">All Services</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ request('service') == $service->id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Area Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Service Area</label>
                    <input type="text" name="area" value="{{ request('area') }}" 
                           placeholder="City or region..."
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6]">
                </div>

                <!-- Sort -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                    <select name="sort" class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6]">
                        <option value="recommended" {{ request('sort', 'recommended') == 'recommended' ? 'selected' : '' }}>Recommended</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                        <option value="experience" {{ request('sort') == 'experience' ? 'selected' : '' }}>Most Experienced</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 flex justify-end">
                <button type="submit" class="bg-[#3b82f6] text-white px-6 py-2 rounded-md hover:bg-[#2563eb] transition">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Results Count -->
    <div class="mb-6">
        <p class="text-gray-600">Showing {{ $electricians->firstItem() ?? 0 }} - {{ $electricians->lastItem() ?? 0 }} of {{ $electricians->total() }} electricians</p>
    </div>

    <!-- Electricians Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($electricians as $electrician)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                <div class="p-6">
                    <!-- Header with Avatar -->
                    <div class="flex items-center mb-4">
                        <div class="h-16 w-16 rounded-full bg-[#1e3a5f] flex items-center justify-center text-white text-2xl font-bold">
                            {{ substr($electrician->business_name, 0, 1) }}
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-[#1e3a5f]">{{ $electrician->business_name }}</h3>
                            <p class="text-sm text-gray-600">{{ $electrician->user->name }}</p>
                        </div>
                    </div>

                    <!-- Rating -->
                    <div class="flex items-center mb-3">
                        <div class="flex text-amber-400">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($electrician->reviews_avg_rating ?? 0))
                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 fill-current text-gray-300" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="ml-2 text-sm text-gray-600">({{ $electrician->reviews_count ?? 0 }} reviews)</span>
                    </div>

                    <!-- Details -->
                    <div class="space-y-2 mb-4">
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Experience:</span> {{ $electrician->years_experience }} years
                        </p>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Rate:</span> 
                            <span class="text-lg font-bold text-[#3b82f6]">${{ number_format($electrician->hourly_rate, 2) }}</span>/hour
                        </p>
                        @if($electrician->is_verified)
                            <p class="text-sm">
                                <span class="inline-flex items-center px-2 py-1 rounded-full bg-green-100 text-green-800 text-xs">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Verified Professional
                                </span>
                            </p>
                        @endif
                    </div>

                    <!-- Service Areas -->
                    @if($electrician->service_areas)
                        <div class="mb-4">
                            <p class="text-sm font-medium text-gray-700 mb-2">Service Areas:</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach(array_slice($electrician->service_areas, 0, 3) as $area)
                                    <span class="px-2 py-1 bg-gray-100 rounded-full text-xs text-gray-600">{{ $area }}</span>
                                @endforeach
                                @if(count($electrician->service_areas) > 3)
                                    <span class="px-2 py-1 bg-gray-100 rounded-full text-xs text-gray-600">
                                        +{{ count($electrician->service_areas) - 3 }} more
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="mt-4 flex space-x-3">
                        <a href="{{ route('electricians.show', $electrician) }}" 
                           class="flex-1 bg-[#1e3a5f] text-white text-center px-4 py-2 rounded-md hover:bg-[#162c48] transition">
                            View Profile
                        </a>
                        <a href="{{ route('bookings.create', ['electrician_id' => $electrician->id]) }}" 
                           class="flex-1 bg-[#3b82f6] text-white text-center px-4 py-2 rounded-md hover:bg-[#2563eb] transition">
                            Book Now
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No electricians found</h3>
                <p class="mt-1 text-sm text-gray-500">Try adjusting your filters or search criteria.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $electricians->withQueryString()->links() }}
    </div>
</div>
@endsection