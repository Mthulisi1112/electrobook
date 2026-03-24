@extends('layouts.app')

@section('title', 'Edit ' . $electrician->business_name)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('admin.electricians.index') }}" class="text-[#3b82f6] hover:text-[#2563eb] flex items-center mb-4">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Electricians
        </a>
        <h1 class="text-3xl font-bold text-[#1e3a5f]">Edit Electrician</h1>
        <p class="text-gray-600 mt-2">{{ $electrician->business_name }}</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('admin.electricians.update', $electrician) }}">
            @csrf
            @method('PUT')

            <!-- Account Information -->
            <h2 class="text-lg font-semibold text-[#1e3a5f] mb-4 pb-2 border-b">Account Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $electrician->user->name) }}" required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6]">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $electrician->user->email) }}" required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6]">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $electrician->phone) }}" required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6]">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Business Information -->
            <h2 class="text-lg font-semibold text-[#1e3a5f] mb-4 pb-2 border-b">Business Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Business Name -->
                <div class="md:col-span-2">
                    <label for="business_name" class="block text-sm font-medium text-gray-700 mb-1">Business Name *</label>
                    <input type="text" name="business_name" id="business_name" value="{{ old('business_name', $electrician->business_name) }}" required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6]">
                    @error('business_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- License Number -->
                <div>
                    <label for="license_number" class="block text-sm font-medium text-gray-700 mb-1">License Number *</label>
                    <input type="text" name="license_number" id="license_number" value="{{ old('license_number', $electrician->license_number) }}" required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6]">
                    @error('license_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Years Experience -->
                <div>
                    <label for="years_experience" class="block text-sm font-medium text-gray-700 mb-1">Years Experience *</label>
                    <input type="number" name="years_experience" id="years_experience" value="{{ old('years_experience', $electrician->years_experience) }}" required
                           min="0" max="100"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6]">
                    @error('years_experience')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Hourly Rate -->
                <div>
                    <label for="hourly_rate" class="block text-sm font-medium text-gray-700 mb-1">Hourly Rate ($) *</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input type="number" name="hourly_rate" id="hourly_rate" value="{{ old('hourly_rate', $electrician->hourly_rate) }}" required
                               step="0.01" min="0"
                               class="pl-7 w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6]">
                    </div>
                    @error('hourly_rate')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bio -->
                <div class="md:col-span-2">
                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Bio / Description</label>
                    <textarea name="bio" id="bio" rows="4"
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6]">{{ old('bio', $electrician->bio) }}</textarea>
                    @error('bio')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Service Areas -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Service Areas</label>
                    <div class="space-y-2" x-data="{ areas: {{ json_encode(old('service_areas', $electrician->service_areas ?? [])) }} }">
                        <template x-for="(area, index) in areas" :key="index">
                            <div class="flex items-center space-x-2">
                                <input type="text" :name="`service_areas[${index}]`" x-model="areas[index]"
                                       class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6]">
                                <button type="button" @click="areas.splice(index, 1)" 
                                        class="text-red-600 hover:text-red-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </template>
                        <button type="button" @click="areas.push('')" 
                                class="mt-2 text-[#3b82f6] hover:text-[#2563eb] text-sm flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Service Area
                        </button>
                    </div>
                    @error('service_areas')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t">
                <a href="{{ route('admin.electricians.show', $electrician) }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-[#3b82f6] text-white rounded-md hover:bg-[#2563eb]">
                    Update Electrician
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush