@props(['route' => 'admin.electricians.index'])

<form method="GET" action="{{ route($route) }}" class="bg-white rounded-lg shadow p-6 mb-6">
    <!-- Search - Full Width -->
    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">Search Electricians</label>
        <div class="relative">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Search by name, email, or business name..."
                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#3b82f6] focus:border-[#3b82f6] transition">
            
        </div>
    </div>

    <!-- Filter Grid - 4 Columns -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Verification Status -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Verification</label>
            <select name="verification" 
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-[#3b82f6] focus:border-[#3b82f6] transition bg-white">
                <option value="">All Electricians</option>
                <option value="verified" {{ request('verification') == 'verified' ? 'selected' : '' }}>Verified</option>
                <option value="pending" {{ request('verification') == 'pending' ? 'selected' : '' }}>Pending</option>
            </select>
        </div>

        <!-- Sort By -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
            <select name="sort" 
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-[#3b82f6] focus:border-[#3b82f6] transition bg-white">
                <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Latest</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                <option value="bookings" {{ request('sort') == 'bookings' ? 'selected' : '' }}>Most Bookings</option>
            </select>
        </div>

        <!-- Min Experience -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Min Experience</label>
            <select name="min_experience" 
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-[#3b82f6] focus:border-[#3b82f6] transition bg-white">
                <option value="">Any experience</option>
                <option value="1" {{ request('min_experience') == 1 ? 'selected' : '' }}>1+ years</option>
                <option value="3" {{ request('min_experience') == 3 ? 'selected' : '' }}>3+ years</option>
                <option value="5" {{ request('min_experience') == 5 ? 'selected' : '' }}>5+ years</option>
                <option value="10" {{ request('min_experience') == 10 ? 'selected' : '' }}>10+ years</option>
            </select>
        </div>

        <!-- Min Rating -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Min Rating</label>
            <select name="min_rating" 
                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-[#3b82f6] focus:border-[#3b82f6] transition bg-white">
                <option value="">Any rating</option>
                <option value="4" {{ request('min_rating') == 4 ? 'selected' : '' }}>4+ ★</option>
                <option value="3" {{ request('min_rating') == 3 ? 'selected' : '' }}>3+ ★</option>
                <option value="2" {{ request('min_rating') == 2 ? 'selected' : '' }}>2+ ★</option>
            </select>
        </div>
    </div>

    <!-- Active Filters Display -->
    @php
        $activeFilters = collect(request()->only(['verification', 'min_experience', 'min_rating']))->filter()->count();
        $hasActiveFilters = request('search') || $activeFilters > 0;
    @endphp

    @if($hasActiveFilters)
        <div class="flex flex-wrap items-center gap-2 mb-4 pb-4 border-b border-gray-200">
            <span class="text-sm text-gray-500">Active filters:</span>
            @if(request('search'))
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    "{{ request('search') }}"
                    <a href="{{ route($route, array_merge(request()->except(['search', 'page']))) }}" class="ml-2 hover:text-blue-600">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                </span>
            @endif
            @if(request('verification'))
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ request('verification') == 'verified' ? 'Verified' : 'Pending' }}
                    <a href="{{ route($route, array_merge(request()->except(['verification', 'page']))) }}" class="ml-2 hover:text-blue-600">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                </span>
            @endif
            @if(request('min_experience'))
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ request('min_experience') }}+ years
                    <a href="{{ route($route, array_merge(request()->except(['min_experience', 'page']))) }}" class="ml-2 hover:text-blue-600">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                </span>
            @endif
            @if(request('min_rating'))
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ request('min_rating') }}+ ★
                    <a href="{{ route($route, array_merge(request()->except(['min_rating', 'page']))) }}" class="ml-2 hover:text-blue-600">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                </span>
            @endif
        </div>
    @endif

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row justify-end gap-3">
        @if($hasActiveFilters)
            <a href="{{ route($route) }}" 
               class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-center">
                Clear All Filters
            </a>
        @endif
        <button type="submit" 
                class="px-8 py-2.5 bg-[#3b82f6] text-white rounded-lg hover:bg-[#2563eb] transition shadow-sm">
            Apply Filters
        </button>
    </div>
</form>