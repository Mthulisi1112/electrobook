@props(['categories'])

<div class="bg-white rounded-lg shadow-lg p-6 mb-8">
    <form method="GET" action="{{ route('services.index') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="lg:col-span-2">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">
                    Search Services
                </label>
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           id="search"
                           value="{{ request('search') }}"
                           placeholder="Search by name or description..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
                    <div class="absolute left-3 top-2.5">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Category Filter -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">
                    Category
                </label>
                <select name="category" 
                        id="category"
                        class="w-full border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Sort By -->
            <div>
                <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">
                    Sort By
                </label>
                <select name="sort" 
                        id="sort"
                        class="w-full border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
                    <option value="name_asc" {{ request('sort', 'name_asc') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Min Price -->
            <div>
                <label for="min_price" class="block text-sm font-medium text-gray-700 mb-1">
                    Min Price ($)
                </label>
                <input type="number" 
                       name="min_price" 
                       id="min_price"
                       value="{{ request('min_price') }}"
                       placeholder="Any"
                       min="0"
                       step="10"
                       class="w-full border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
            </div>

            <!-- Max Price -->
            <div>
                <label for="max_price" class="block text-sm font-medium text-gray-700 mb-1">
                    Max Price ($)
                </label>
                <input type="number" 
                       name="max_price" 
                       id="max_price"
                       value="{{ request('max_price') }}"
                       placeholder="Any"
                       min="0"
                       step="10"
                       class="w-full border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
            </div>

            <!-- Max Duration -->
            <div>
                <label for="max_duration" class="block text-sm font-medium text-gray-700 mb-1">
                    Max Duration (minutes)
                </label>
                <select name="max_duration" 
                        id="max_duration"
                        class="w-full border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
                    <option value="">Any Duration</option>
                    <option value="30" {{ request('max_duration') == 30 ? 'selected' : '' }}>Under 30 min</option>
                    <option value="60" {{ request('max_duration') == 60 ? 'selected' : '' }}>Under 1 hour</option>
                    <option value="120" {{ request('max_duration') == 120 ? 'selected' : '' }}>Under 2 hours</option>
                    <option value="180" {{ request('max_duration') == 180 ? 'selected' : '' }}>Under 3 hours</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end space-x-3 pt-4 border-t">
            <a href="{{ route('services.index') }}" 
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