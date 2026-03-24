@props(['user'])

@if($user->isElectrician() && $user->electrician)
    <section id="business-info" class="bg-white rounded-xl shadow-lg p-6 mt-6 scroll-mt-20">
        <h2 class="text-xl font-semibold text-[#1e3a5f] mb-6 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            Business Information
        </h2>
        
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- Business Name -->
            <div>
                <label for="business_name" class="block text-sm font-medium text-gray-700 mb-1">
                    Business Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="business_name" 
                       id="business_name" 
                       value="{{ old('business_name', $user->electrician->business_name) }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('business_name') border-red-500 @enderror"
                       required>
                @error('business_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bio -->
            <div>
                <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">
                    Bio / Description
                </label>
                <textarea name="bio" 
                          id="bio" 
                          rows="4"
                          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('bio') border-red-500 @enderror"
                          placeholder="Tell clients about your experience and expertise...">{{ old('bio', $user->electrician->bio) }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Briefly describe your experience and expertise (max 1000 characters).</p>
                @error('bio')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Years Experience -->
                <div>
                    <label for="years_experience" class="block text-sm font-medium text-gray-700 mb-1">
                        Years Experience
                    </label>
                    <input type="number" 
                           name="years_experience" 
                           id="years_experience" 
                           value="{{ old('years_experience', $user->electrician->years_experience) }}"
                           min="0" 
                           max="100"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('years_experience') border-red-500 @enderror">
                    @error('years_experience')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Hourly Rate -->
                <div>
                    <label for="hourly_rate" class="block text-sm font-medium text-gray-700 mb-1">
                        Hourly Rate ($)
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">$</span>
                        </div>
                        <input type="number" 
                               name="hourly_rate" 
                               id="hourly_rate" 
                               value="{{ old('hourly_rate', $user->electrician->hourly_rate) }}"
                               min="0" 
                               step="0.01"
                               class="pl-8 w-full rounded-lg border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('hourly_rate') border-red-500 @enderror">
                    </div>
                    @error('hourly_rate')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- License Number -->
            <div>
                <label for="license_number" class="block text-sm font-medium text-gray-700 mb-1">
                    License Number
                </label>
                <input type="text" 
                       name="license_number" 
                       id="license_number" 
                       value="{{ old('license_number', $user->electrician->license_number) }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('license_number') border-red-500 @enderror">
                @error('license_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Service Areas -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Service Areas
                </label>
                <div class="space-y-3" x-data="{ 
                    areas: {{ json_encode(old('service_areas', $user->electrician->service_areas ?? [])) }} 
                }">
                    <template x-for="(area, index) in areas" :key="index">
                        <div class="flex items-center space-x-2">
                            <input type="text" 
                                   :name="`service_areas[${index}]`" 
                                   x-model="areas[index]"
                                   class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6]">
                            <button type="button" 
                                    @click="areas.splice(index, 1)" 
                                    class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </template>
                    
                    <button type="button" 
                            @click="areas.push('')" 
                            class="mt-2 inline-flex items-center px-4 py-2 border-2 border-dashed border-gray-300 rounded-lg text-sm text-[#3b82f6] hover:text-[#2563eb] hover:border-[#3b82f6] hover:bg-blue-50 transition">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Service Area
                    </button>
                </div>
                @error('service_areas')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-xs text-gray-500">Add cities or regions where you provide services.</p>
            </div>

            <div class="flex justify-end pt-4 border-t">
                <button type="submit" 
                        class="inline-flex items-center px-6 py-2.5 bg-[#3b82f6] text-white rounded-lg hover:bg-[#2563eb] transition shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Business Information
                </button>
            </div>
        </form>
    </section>
@endif