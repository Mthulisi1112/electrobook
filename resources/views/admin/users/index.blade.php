@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#1e3a5f]">Users</h1>
            <p class="text-gray-600 mt-2">Manage all platform users</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.users.export') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Export CSV
            </a>
            <a href="{{ route('admin.users.create') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#3b82f6] hover:bg-[#2563eb]">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add User
            </a>
        </div>
    </div>

    <!-- Stats -->
    <x-admin.user-stats :stats="$stats" />

    <!-- Filters -->
    <x-admin.user-filters :stats="$stats" />

    <!-- Bulk Actions -->
    <div class="mb-4 flex justify-between items-center">
        <p class="text-sm text-gray-600">
            Showing {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users
        </p>
        @if($users->total() > 0)
            <div class="flex space-x-3">
                <button onclick="showBulkVerifyModal()" 
                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    <svg class="-ml-1 mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Bulk Verify
                </button>
                <button onclick="showBulkDeleteModal()" 
                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    <svg class="-ml-1 mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Bulk Delete
                </button>
            </div>
        @endif
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        User
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Role
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Phone
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Email Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Joined
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                    <x-admin.user-table-row :user="$user" />
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No users found</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new user.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.users.create') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#3b82f6] hover:bg-[#2563eb]">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add User
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $users->withQueryString()->links() }}
    </div>
</div>

<!-- Bulk Verify Modal -->
<div id="bulkVerifyModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h3 class="text-lg font-semibold text-[#1e3a5f] mb-4">Bulk Verify Users</h3>
        <form method="POST" action="{{ route('admin.users.bulk-verify') }}">
            @csrf
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-4">This will verify email addresses for all filtered users.</p>
                <p class="text-sm font-medium text-gray-900">Users to verify: {{ $users->total() }}</p>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="hideBulkVerifyModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    Confirm Verify
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Bulk Delete Modal -->
<div id="bulkDeleteModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h3 class="text-lg font-semibold text-red-600 mb-4">Bulk Delete Users</h3>
        <form method="POST" action="{{ route('admin.users.bulk-delete') }}">
            @csrf
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-4">Are you sure you want to delete all filtered users? This action cannot be undone.</p>
                <p class="text-sm font-medium text-gray-900">Users to delete: {{ $users->total() }}</p>
                <p class="text-xs text-red-600 mt-2">Note: Your own account will be excluded.</p>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="hideBulkDeleteModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Confirm Delete
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showBulkVerifyModal() {
    document.getElementById('bulkVerifyModal').classList.remove('hidden');
    document.getElementById('bulkVerifyModal').classList.add('flex');
}

function hideBulkVerifyModal() {
    document.getElementById('bulkVerifyModal').classList.add('hidden');
    document.getElementById('bulkVerifyModal').classList.remove('flex');
}

function showBulkDeleteModal() {
    document.getElementById('bulkDeleteModal').classList.remove('hidden');
    document.getElementById('bulkDeleteModal').classList.add('flex');
}

function hideBulkDeleteModal() {
    document.getElementById('bulkDeleteModal').classList.add('hidden');
    document.getElementById('bulkDeleteModal').classList.remove('flex');
}

// Close modals when clicking outside
window.onclick = function(event) {
    if (event.target.classList.contains('fixed')) {
        hideBulkVerifyModal();
        hideBulkDeleteModal();
    }
}
</script>
@endsection