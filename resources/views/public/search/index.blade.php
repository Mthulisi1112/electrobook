@extends('layouts.app')

@section('title', 'Search Results - ElectroBook')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Search Header -->
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
            Search Results
        </h1>
        @if($totalResults > 0)
            <p class="text-gray-600">Found {{ $totalResults }} electrician{{ $totalResults > 1 ? 's' : '' }} 
                @if($query) for "{{ $query }}" @endif
                @if($category) in {{ $category }} @endif
            </p>
        @elseif($query || $category)
            <p class="text-gray-600">No results found 
                @if($query) for "{{ $query }}" @endif
                @if($category) in {{ $category }} @endif
            </p>
        @else
            <p class="text-gray-600">Browse all verified electricians</p>
        @endif
    </div>

    <!-- Search Form with Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <form action="{{ route('search') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search Input -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input type="text" 
                           name="q" 
                           value="{{ $query }}"
                           placeholder="Business name, service, or keyword..."
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-[#1e3a5f] focus:ring focus:ring-[#1e3a5f]/20">
                </div>
                
                <!-- Category Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select name="category" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-[#1e3a5f] focus:ring focus:ring-[#1e3a5f]/20">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Sort Dropdown -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sort by</label>
                    <select name="sort" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-[#1e3a5f] focus:ring focus:ring-[#1e3a5f]/20">
                        <option value="rating" {{ $sort == 'rating' ? 'selected' : '' }}>Top Rated</option>
                        <option value="reviews" {{ $sort == 'reviews' ? 'selected' : '' }}>Most Reviews</option>
                        <option value="price_low" {{ $sort == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ $sort == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="experience" {{ $sort == 'experience' ? 'selected' : '' }}>Years Experience</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full px-6 py-2 bg-[#1e3a5f] text-white rounded-lg hover:bg-[#2b4c7c] transition">
                        Update Results
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Results Grid -->
    @if($electricians->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($electricians as $electrician)
                <a href="{{ route('electricians.show', $electrician) }}" class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group border border-gray-200">
                    <div class="relative h-32 bg-gradient-to-r from-[#1e3a5f] to-[#2b4c7c]">
                        <div class="absolute -bottom-10 left-1/2 transform -translate-x-1/2">
                            <div class="w-20 h-20 rounded-full border-4 border-white bg-white overflow-hidden shadow-lg">
                                @php
                                    $businessName = $electrician->business_name ?? 'E';
                                    $initials = '';
                                    $nameParts = explode(' ', $businessName);
                                    foreach ($nameParts as $part) {
                                        if (!empty($part)) {
                                            $initials .= strtoupper(substr($part, 0, 1));
                                        }
                                    }
                                    if (empty($initials)) {
                                        $initials = strtoupper(substr($businessName, 0, 1));
                                    }
                                    $avatarUrl = "https://ui-avatars.com/api/?background=1e3a5f&color=fff&bold=true&size=128&name=" . urlencode($initials);
                                @endphp
                                
                                @if($electrician->user && $electrician->user->profile_photo_path && !str_contains($electrician->user->profile_photo_path, 'ui-avatars.com'))
                                    <img src="{{ Storage::url($electrician->user->profile_photo_path) }}" 
                                         alt="{{ $electrician->business_name }}" 
                                         class="w-full h-full object-cover"
                                         onerror="this.onerror=null; this.src='{{ $avatarUrl }}'">
                                @else
                                    <img src="{{ $avatarUrl }}" 
                                         alt="{{ $electrician->business_name }}" 
                                         class="w-full h-full object-cover">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="pt-12 p-5 text-center">
                        <h3 class="font-semibold text-gray-900 mb-1">{{ $electrician->business_name }}</h3>
                        <p class="text-sm text-gray-500 mb-3">{{ $electrician->years_experience }} years exp.</p>
                        
                        <div class="flex items-center justify-center mb-3">
                            <div class="flex text-amber-400">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($electrician->reviews_avg_rating ?? 0))
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">★</svg>
                                    @else
                                        <svg class="w-4 h-4 fill-current text-gray-300" viewBox="0 0 20 20">★</svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500 ml-2">({{ $electrician->reviews_count ?? 0 }})</span>
                        </div>
                        
                        @if($electrician->services->isNotEmpty())
                            <div class="flex flex-wrap justify-center gap-1 mb-3">
                                @foreach($electrician->services->take(2) as $service)
                                    <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">
                                        {{ $service->name }}
                                    </span>
                                @endforeach
                                @if($electrician->services->count() > 2)
                                    <span class="text-xs text-gray-400">+{{ $electrician->services->count() - 2 }}</span>
                                @endif
                            </div>
                        @endif
                        
                        <div class="text-[#1e3a5f] font-bold text-lg">
                            ${{ number_format($electrician->hourly_rate ?? 85, 0) }}<span class="text-sm font-normal text-gray-500">/hr</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $electricians->appends(request()->query())->links() }}
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No electricians found</h3>
            <p class="text-gray-500 mb-6">
                @if($query || $category)
                    Try adjusting your search or filters to find what you're looking for.
                @else
                    There are no electricians available at the moment.
                @endif
            </p>
            <a href="{{ route('search') }}" class="inline-flex items-center px-4 py-2 bg-[#1e3a5f] text-white rounded-lg hover:bg-[#2b4c7c] transition">
                Clear all filters
            </a>
        </div>
    @endif

</div>
@endsection