@extends('layouts.app')

@section('title', 'Edit ' . $service->name)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('admin.services.index') }}" class="text-[#3b82f6] hover:text-[#2563eb] flex items-center mb-4">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Services
        </a>
        <h1 class="text-3xl font-bold text-[#1e3a5f]">Edit Service</h1>
        <p class="text-gray-600 mt-2">{{ $service->name }}</p>
    </div>

    <!-- Status Banner for Inactive Services -->
    @if(!$service->is_active)
        <div class="bg-amber-50 border-l-4 border-amber-400 p-4 mb-8">
            <div class="flex">
                <div class="shrink-0">
                    <svg class="h-5 w-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-amber-700">
                        This service is currently inactive and not visible to customers.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('admin.services.update', $service) }}">
            @csrf
            @method('PUT')

            <!-- Service Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Service Name *</label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name', $service->name) }}" 
                       required
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" 
                          id="description" 
                          rows="4"
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('description') border-red-500 @enderror">{{ old('description', $service->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                    <input type="text" 
                           name="category" 
                           id="category" 
                           value="{{ old('category', $service->category) }}" 
                           required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('category') border-red-500 @enderror">
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icon -->
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">Icon (Emoji or SVG Path)</label>
                    <input type="text" 
                           name="icon" 
                           id="icon" 
                           value="{{ old('icon', $service->icon) }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('icon') border-red-500 @enderror">
                    @error('icon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Base Price -->
                <div>
                    <label for="base_price" class="block text-sm font-medium text-gray-700 mb-1">Base Price ($) *</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input type="number" 
                               name="base_price" 
                               id="base_price" 
                               value="{{ old('base_price', $service->base_price) }}" 
                               required
                               step="0.01" 
                               min="0"
                               class="pl-7 w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('base_price') border-red-500 @enderror">
                    </div>
                    @error('base_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Duration -->
                <div>
                    <label for="estimated_duration_minutes" class="block text-sm font-medium text-gray-700 mb-1">Estimated Duration (minutes) *</label>
                    <input type="number" 
                           name="estimated_duration_minutes" 
                           id="estimated_duration_minutes" 
                           value="{{ old('estimated_duration_minutes', $service->estimated_duration_minutes) }}" 
                           required
                           min="15" 
                           step="15"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('estimated_duration_minutes') border-red-500 @enderror">
                    @error('estimated_duration_minutes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Active Status -->
            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" 
                           name="is_active" 
                           id="is_active" 
                           value="1" 
                           {{ old('is_active', $service->is_active) ? 'checked' : '' }}
                           class="h-4 w-4 text-[#3b82f6] focus:ring-[#3b82f6] border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Active (available for booking)
                    </label>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t">
                <a href="{{ route('admin.services.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-[#3b82f6] text-white rounded-md hover:bg-[#2563eb]">
                    Update Service
                </button>
            </div>
        </form>
    </div>

    <!-- Danger Zone (Only show if service has no bookings) -->
    @if(!$service->bookings()->exists())
        <div class="mt-8 bg-white rounded-lg shadow p-6 border-2 border-red-200">
            <h2 class="text-xl font-semibold text-red-600 mb-4">Danger Zone</h2>
            <p class="text-gray-600 mb-4">Once you delete a service, there is no going back. Please be certain.</p>
            
            <form method="POST" action="{{ route('admin.services.destroy', $service) }}"
                  onsubmit="return confirm('Are you sure you want to delete this service? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Delete Service
                </button>
            </form>
        </div>
    @else
        <div class="mt-8 bg-gray-50 rounded-lg p-4">
            <p class="text-sm text-gray-600">
                <svg class="inline-block w-5 h-5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                This service cannot be deleted because it has existing bookings. You can deactivate it instead.
            </p>
        </div>
    @endif
</div>
@endsection