@extends('layouts.app')

@section('title', 'Add Service')

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
        <h1 class="text-3xl font-bold text-[#1e3a5f]">Add New Service</h1>
        <p class="text-gray-600 mt-2">Create a new service offering for electricians</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('admin.services.store') }}">
            @csrf

            <!-- Service Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Service Name *</label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name') }}" 
                       required
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('name') border-red-500 @enderror"
                       placeholder="e.g., Emergency Electrical Repair">
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
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('description') border-red-500 @enderror"
                          placeholder="Describe the service...">{{ old('description') }}</textarea>
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
                           value="{{ old('category') }}" 
                           required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('category') border-red-500 @enderror"
                           placeholder="e.g., Emergency, Installation, Repair">
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
                           value="{{ old('icon') }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('icon') border-red-500 @enderror"
                           placeholder="e.g., ⚡ or bolt">
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
                               value="{{ old('base_price') }}" 
                               required
                               step="0.01" 
                               min="0"
                               class="pl-7 w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('base_price') border-red-500 @enderror"
                               placeholder="0.00">
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
                           value="{{ old('estimated_duration_minutes', 60) }}" 
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
                           {{ old('is_active', true) ? 'checked' : '' }}
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
                    Create Service
                </button>
            </div>
        </form>
    </div>
</div>
@endsection