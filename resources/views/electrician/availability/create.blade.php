@extends('layouts.app')

@section('title', 'Add Availability')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('electrician.availability.index') }}" class="text-[#3b82f6] hover:text-[#2563eb] flex items-center mb-4">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Availability
        </a>
        
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-[#1e3a5f]">Add Availability</h1>
                <p class="text-gray-600 mt-2">Choose how you want to add your availability</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('electrician.availability.create') }}" 
                   class="px-4 py-2 {{ !request('bulk') ? 'bg-[#3b82f6] text-white' : 'bg-white text-gray-700 border border-gray-300' }} rounded-md hover:bg-[#2563eb] hover:text-white transition">
                    Single Slot
                </a>
                <a href="{{ route('electrician.availability.create') }}?bulk=1" 
                   class="px-4 py-2 {{ request('bulk') ? 'bg-[#3b82f6] text-white' : 'bg-white text-gray-700 border border-gray-300' }} rounded-md hover:bg-[#2563eb] hover:text-white transition">
                    Bulk Create
                </a>
            </div>
        </div>
    </div>

    @if(request('bulk'))
        <!-- Bulk Creation Form -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Bulk Create Availability Slots</h2>
            <p class="text-sm text-gray-600 mb-6">Create multiple slots at once for a date range on selected weekdays.</p>

            <form method="POST" action="{{ route('electrician.availability.bulk') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Start Date -->
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date *</label>
                        <input type="date" 
                               name="start_date" 
                               id="start_date" 
                               value="{{ old('start_date', now()->format('Y-m-d')) }}" 
                               min="{{ now()->format('Y-m-d') }}"
                               required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('start_date') border-red-500 @enderror">
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date *</label>
                        <input type="date" 
                               name="end_date" 
                               id="end_date" 
                               value="{{ old('end_date', now()->addWeeks(2)->format('Y-m-d')) }}" 
                               min="{{ now()->format('Y-m-d') }}"
                               required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('end_date') border-red-500 @enderror">
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Weekdays -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Weekdays *</label>
                    <div class="grid grid-cols-7 gap-2">
                        @php
                            $weekdays = [
                                0 => 'Sun', 1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 
                                4 => 'Thu', 5 => 'Fri', 6 => 'Sat'
                            ];
                            $oldWeekdays = old('weekdays', [1,2,3,4,5]); // Default to weekdays
                        @endphp
                        
                        @foreach($weekdays as $key => $day)
                            <label class="relative flex items-center justify-center p-3 border rounded-lg cursor-pointer hover:border-[#3b82f6] transition
                                {{ in_array($key, $oldWeekdays) ? 'border-[#3b82f6] bg-blue-50' : 'border-gray-200' }}">
                                <input type="checkbox" 
                                       name="weekdays[]" 
                                       value="{{ $key }}" 
                                       class="sr-only weekday-checkbox"
                                       {{ in_array($key, $oldWeekdays) ? 'checked' : '' }}>
                                <span class="text-sm font-medium">{{ $day }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('weekdays')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @error('weekdays.*')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Start Time -->
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Start Time *</label>
                        <input type="time" 
                               name="start_time" 
                               id="start_time" 
                               value="{{ old('start_time', '09:00') }}" 
                               required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('start_time') border-red-500 @enderror">
                        @error('start_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Time -->
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">End Time *</label>
                        <input type="time" 
                               name="end_time" 
                               id="end_time" 
                               value="{{ old('end_time', '17:00') }}" 
                               required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('end_time') border-red-500 @enderror">
                        @error('end_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Preview Info -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6" id="previewInfo">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Preview</h3>
                    <p class="text-sm text-gray-600" id="previewText">
                        Select dates and weekdays to see preview
                    </p>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t">
                    <a href="{{ route('electrician.availability.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-[#3b82f6] text-white rounded-md hover:bg-[#2563eb]">
                        Create Slots
                    </button>
                </div>
            </form>
        </div>
    @else
        <!-- Single Slot Creation Form -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-[#1e3a5f] mb-4">Create Single Availability Slot</h2>

            <form method="POST" action="{{ route('electrician.availability.store') }}">
                @csrf

                <!-- Date -->
                <div class="mb-6">
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date *</label>
                    <input type="date" 
                           name="date" 
                           id="date" 
                           value="{{ old('date', now()->format('Y-m-d')) }}" 
                           min="{{ now()->format('Y-m-d') }}"
                           required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('date') border-red-500 @enderror">
                    @error('date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Start Time -->
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Start Time *</label>
                        <input type="time" 
                               name="start_time" 
                               id="start_time" 
                               value="{{ old('start_time', '09:00') }}" 
                               required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('start_time') border-red-500 @enderror">
                        @error('start_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Time -->
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">End Time *</label>
                        <input type="time" 
                               name="end_time" 
                               id="end_time" 
                               value="{{ old('end_time', '17:00') }}" 
                               required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('end_time') border-red-500 @enderror">
                        @error('end_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Duration Preview -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Duration</h3>
                    <p class="text-sm text-gray-600" id="durationPreview">
                        Select start and end times to see duration
                    </p>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t">
                    <a href="{{ route('electrician.availability.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-[#3b82f6] text-white rounded-md hover:bg-[#2563eb]">
                        Create Slot
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(request('bulk'))
        // Bulk preview calculation
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');
        const weekdays = document.querySelectorAll('.weekday-checkbox');
        const previewText = document.getElementById('previewText');

        function updateBulkPreview() {
            if (!startDate.value || !endDate.value) return;

            const start = new Date(startDate.value);
            const end = new Date(endDate.value);
            const selectedWeekdays = Array.from(weekdays)
                .filter(cb => cb.checked)
                .map(cb => parseInt(cb.value));

            if (selectedWeekdays.length === 0) {
                previewText.textContent = 'Select at least one weekday';
                return;
            }

            // Calculate number of slots
            let count = 0;
            let current = new Date(start);
            
            while (current <= end) {
                if (selectedWeekdays.includes(current.getDay())) {
                    count++;
                }
                current.setDate(current.getDate() + 1);
            }

            const startFormatted = startDate.value.split('-').reverse().join('/');
            const endFormatted = endDate.value.split('-').reverse().join('/');
            
            previewText.textContent = `This will create approximately ${count} slots from ${startFormatted} to ${endFormatted}`;
        }

        startDate.addEventListener('change', updateBulkPreview);
        endDate.addEventListener('change', updateBulkPreview);
        weekdays.forEach(cb => cb.addEventListener('change', updateBulkPreview));

        // Initial preview
        updateBulkPreview();
    @else
        // Single slot duration preview
        const startTime = document.getElementById('start_time');
        const endTime = document.getElementById('end_time');
        const durationPreview = document.getElementById('durationPreview');

        function updateDuration() {
            if (startTime.value && endTime.value) {
                const start = new Date(`2000-01-01T${startTime.value}`);
                const end = new Date(`2000-01-01T${endTime.value}`);
                const diffHours = (end - start) / (1000 * 60 * 60);
                
                if (diffHours > 0) {
                    durationPreview.textContent = `Duration: ${diffHours.toFixed(1)} hours`;
                } else {
                    durationPreview.textContent = 'End time must be after start time';
                }
            }
        }

        startTime.addEventListener('change', updateDuration);
        endTime.addEventListener('change', updateDuration);

        // Initial duration
        updateDuration();
    @endif
});
</script>
@endsection