@props(['categories'])

<form method="GET" action="{{ route('admin.services.index') }}" class="bg-white rounded-lg shadow p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Search -->
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Search Services</label>
            <div class="relative">
                <input type="text" 
                       name="search" 
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
            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <select name="category" class="w-full border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="flex justify-end mt-4 space-x-3">
        <a href="{{ route('admin.services.index') }}" 
           class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
            Clear Filters
        </a>
        <button type="submit" 
                class="px-6 py-2 bg-[#3b82f6] text-white rounded-lg hover:bg-[#2563eb] transition">
            Apply Filters
        </button>
    </div>
</form>