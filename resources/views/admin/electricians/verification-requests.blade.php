@extends('layouts.app')

@section('title', 'Verification Requests')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#1e3a5f]">Verification Requests</h1>
            <p class="text-gray-600 mt-2">Review and verify pending electrician applications</p>
        </div>
        <a href="{{ route('admin.electricians.index') }}" 
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Electricians
        </a>
    </div>

    <!-- Bulk Actions Form -->
    <form method="POST" action="{{ route('admin.electricians.bulk-verify') }}" id="bulkVerifyForm">
        @csrf
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-[#1e3a5f]">Pending Verifications ({{ $pendingElectricians->total() }})</h2>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed"
                        id="bulkVerifyBtn"
                        disabled>
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Verify Selected
                </button>
            </div>

            @if($pendingElectricians->isEmpty())
                <div class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No pending verifications</h3>
                    <p class="mt-1 text-sm text-gray-500">All electricians have been verified.</p>
                </div>
            @else
                <div class="divide-y divide-gray-200">
                    @foreach($pendingElectricians as $electrician)
                        <div class="p-6 hover:bg-gray-50">
                            <div class="flex items-start">
                                <div class="shrink-0 pt-1">
                                    <input type="checkbox" 
                                           name="electrician_ids[]" 
                                           value="{{ $electrician->id }}"
                                           class="electrician-checkbox h-4 w-4 text-[#3b82f6] focus:ring-[#3b82f6] border-gray-300 rounded">
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-lg font-medium text-[#1e3a5f]">{{ $electrician->business_name }}</h3>
                                            <p class="text-sm text-gray-600">{{ $electrician->user->name }}</p>
                                        </div>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">
                                            Pending
                                        </span>
                                    </div>

                                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <p class="text-xs text-gray-500">Email</p>
                                            <p class="text-sm">{{ $electrician->user->email }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Phone</p>
                                            <p class="text-sm">{{ $electrician->phone }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">License</p>
                                            <p class="text-sm">{{ $electrician->license_number }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Experience</p>
                                            <p class="text-sm">{{ $electrician->years_experience }} years</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Rate</p>
                                            <p class="text-sm font-semibold text-[#3b82f6]">${{ number_format($electrician->hourly_rate, 2) }}/hr</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Joined</p>
                                            <p class="text-sm">{{ $electrician->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>

                                    @if($electrician->service_areas)
                                        <div class="mt-3">
                                            <p class="text-xs text-gray-500 mb-1">Service Areas</p>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($electrician->service_areas as $area)
                                                    <span class="px-2 py-1 bg-gray-100 rounded-full text-xs text-gray-700">{{ $area }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div class="mt-4 flex justify-end space-x-3">
                                        <a href="{{ route('admin.electricians.show', $electrician) }}" 
                                           class="text-sm text-[#3b82f6] hover:text-[#2563eb]">
                                            View Details
                                        </a>
                                        <form method="POST" action="{{ route('admin.electricians.verify', $electrician) }}" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="text-sm text-green-600 hover:text-green-800">
                                                Verify Now
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </form>

    <!-- Pagination -->
    @if($pendingElectricians->hasPages())
        <div class="mt-6">
            {{ $pendingElectricians->withQueryString()->links() }}
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.electrician-checkbox');
    const bulkVerifyBtn = document.getElementById('bulkVerifyBtn');
    const bulkVerifyForm = document.getElementById('bulkVerifyForm');

    function updateBulkVerifyButton() {
        const checkedCount = document.querySelectorAll('.electrician-checkbox:checked').length;
        if (checkedCount > 0) {
            bulkVerifyBtn.disabled = false;
            bulkVerifyBtn.textContent = `Verify Selected (${checkedCount})`;
        } else {
            bulkVerifyBtn.disabled = true;
            bulkVerifyBtn.textContent = 'Verify Selected';
        }
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkVerifyButton);
    });

    bulkVerifyForm.addEventListener('submit', function(e) {
        const checkedCount = document.querySelectorAll('.electrician-checkbox:checked').length;
        if (checkedCount === 0) {
            e.preventDefault();
            alert('Please select at least one electrician to verify.');
        } else {
            if (!confirm(`Are you sure you want to verify ${checkedCount} electrician(s)?`)) {
                e.preventDefault();
            }
        }
    });
});
</script>
@endsection