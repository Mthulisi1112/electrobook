@props(['services', 'serviceAreas'])

<div class="bg-white rounded-lg shadow-lg p-6 mb-8">
    <form method="GET" action="{{ route('electricians.index') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="lg:col-span-2">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">
                    Search Electricians
                </label>
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           id="search"
                           value="{{ request('search') }}"
                           placeholder="Search by name or business..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
                    <div class="absolute left-3 top-2.5">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Service Filter -->
            <div>
                <label for="service" class="block text-sm font-medium text-gray-700 mb-1">
                    Service
                </label>
                <select name="service" 
                        id="service"
                        class="w-full border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
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
                <label for="area" class="block text-sm font-medium text-gray-700 mb-1">
                    Service Area
                </label>
                <select name="area" 
                        id="area"
                        class="w-full border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
                    <option value="">All Areas</option>
                    @foreach($serviceAreas as $area)
                        <option value="{{ $area }}" {{ request('area') == $area ? 'selected' : '' }}>
                            {{ $area }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Min Rating -->
            <div>
                <label for="min_rating" class="block text-sm font-medium text-gray-700 mb-1">
                    Minimum Rating
                </label>
                <select name="min_rating" 
                        id="min_rating"
                        class="w-full border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
                    <option value="">Any Rating</option>
                    <option value="4" {{ request('min_rating') == 4 ? 'selected' : '' }}>4+ Stars</option>
                    <option value="3" {{ request('min_rating') == 3 ? 'selected' : '' }}>3+ Stars</option>
                    <option value="2" {{ request('min_rating') == 2 ? 'selected' : '' }}>2+ Stars</option>
                </select>
            </div>

            <!-- Price Range -->
            <div>
                <label for="max_price" class="block text-sm font-medium text-gray-700 mb-1">
                    Max Hourly Rate ($)
                </label>
                <input type="number" 
                       name="max_price" 
                       id="max_price"
                       value="{{ request('max_price') }}"
                       placeholder="Any price"
                       min="0"
                       step="10"
                       class="w-full border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
            </div>

            <!-- Sort By -->
            <div>
                <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">
                    Sort By
                </label>
                <select name="sort" 
                        id="sort"
                        class="w-full border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
                    <option value="recommended" {{ request('sort', 'recommended') == 'recommended' ? 'selected' : '' }}>Recommended</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                    <option value="experience" {{ request('sort') == 'experience' ? 'selected' : '' }}>Most Experienced</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="reviews" {{ request('sort') == 'reviews' ? 'selected' : '' }}>Most Reviews</option>
                </select>
            </div>
        </div>

        <!-- Available Now Checkbox -->
        <div class="flex items-center">
            <input type="checkbox" 
                   name="available_now" 
                   id="available_now"
                   value="1"
                   {{ request('available_now') ? 'checked' : '' }}
                   class="h-4 w-4 text-[#3b82f6] focus:ring-[#3b82f6] border-gray-300 rounded">
            <label for="available_now" class="ml-2 block text-sm text-gray-900">
                Available now
            </label>
        </div>

        <div class="flex justify-end space-x-3 pt-4 border-t">
            <a href="{{ route('electricians.index') }}" 
               class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Clear Filters
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-[#3b82f6] text-white rounded-lg hover:bg-[#2563eb] transition">
                Apply Filters
            </button>
        </div>
    </form>
</div>