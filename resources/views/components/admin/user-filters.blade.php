@props(['stats'])

<form method="GET" action="{{ route('admin.users.index') }}" class="bg-white rounded-lg shadow p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Search -->
        <div class="lg:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Search Users</label>
            <div class="relative">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search by name, email, or phone..."
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
                <div class="absolute left-3 top-2.5">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Role Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
            <select name="role" class="w-full border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
                <option value="">All Roles</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="electrician" {{ request('role') == 'electrician' ? 'selected' : '' }}>Electrician</option>
                <option value="client" {{ request('role') == 'client' ? 'selected' : '' }}>Client</option>
            </select>
        </div>

        <!-- Verification Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Verification</label>
            <select name="verified" class="w-full border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
                <option value="">All</option>
                <option value="verified" {{ request('verified') == 'verified' ? 'selected' : '' }}>Verified</option>
                <option value="unverified" {{ request('verified') == 'unverified' ? 'selected' : '' }}>Unverified</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
        <!-- Date From -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
            <input type="date" name="from_date" value="{{ request('from_date') }}"
                   class="w-full border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
        </div>

        <!-- Date To -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
            <input type="date" name="to_date" value="{{ request('to_date') }}"
                   class="w-full border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
        </div>

        <!-- Sort -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
            <select name="sort" class="w-full border border-gray-300 rounded-lg focus:ring-[#3b82f6] focus:border-[#3b82f6]">
                <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Latest</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
                <option value="email_asc" {{ request('sort') == 'email_asc' ? 'selected' : '' }}>Email A-Z</option>
                <option value="email_desc" {{ request('sort') == 'email_desc' ? 'selected' : '' }}>Email Z-A</option>
            </select>
        </div>
    </div>

    <div class="flex justify-end mt-4 space-x-3">
        <a href="{{ route('admin.users.index') }}" 
           class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
            Clear Filters
        </a>
        <button type="submit" 
                class="px-6 py-2 bg-[#3b82f6] text-white rounded-lg hover:bg-[#2563eb] transition">
            Apply Filters
        </button>
    </div>
</form>