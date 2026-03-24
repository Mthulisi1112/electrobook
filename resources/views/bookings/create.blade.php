@extends('layouts.app')

@section('title', 'Book an Electrician')

@section('content')
<div class="min-h-screen py-8" 
     x-data="bookingForm()" 
     x-init="init()"
     style="background: linear-gradient(135deg, #f5f0e6 0%, #e8e0d3 50%, #d9cfbf 100%);">

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8 text-center">
            <div class="inline-block p-3 rounded-full bg-white/80 backdrop-blur-sm shadow-lg mb-4">
                <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Book an Electrician</h1>
            <p class="text-gray-600">Schedule your electrical service in a few simple steps</p>
            
            <!-- Progress Steps -->
            <div class="flex justify-center mt-6 space-x-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-amber-600 text-white flex items-center justify-center font-bold">1</div>
                    <span class="ml-2 text-gray-700 text-sm">Electrician</span>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold">2</div>
                    <span class="ml-2 text-gray-600 text-sm">Service</span>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold">3</div>
                    <span class="ml-2 text-gray-600 text-sm">Date & Time</span>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold">4</div>
                    <span class="ml-2 text-gray-600 text-sm">Details</span>
                </div>
            </div>
        </div>

        <!-- Error Display -->
        <template x-if="errors.length > 0">
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded shadow">
                <div class="flex">
                    <div class="shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                <template x-for="error in errors" :key="error">
                                    <li x-text="error"></li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Booking Form -->
        <div class="bg-white rounded-xl shadow-xl p-6">
            <form method="POST" action="{{ route('bookings.store') }}" id="bookingForm">
                @csrf
                
                <!-- Hidden inputs for Alpine.js values - these will be submitted -->
                <input type="hidden" name="electrician_id" :value="selectedElectrician">
                <input type="hidden" name="service_id" :value="selectedService">
                <input type="hidden" name="availability_slot_id" :value="selectedSlot">
                <input type="hidden" name="description" :value="formData.description">
                <input type="hidden" name="address" :value="formData.address">
                <input type="hidden" name="city" :value="formData.city">
                <input type="hidden" name="postal_code" :value="formData.postal_code">

                <!-- Step 1: Select Electrician -->
                <div class="mb-8" :class="selectedElectrician ? 'opacity-50 pointer-events-none' : ''">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-amber-600 text-white text-xs flex items-center justify-center mr-2">1</span>
                        Select an Electrician
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($electricians as $electrician)
                            <div @click="selectElectrician({{ $electrician->id }})" 
                                class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-amber-500 transition"
                                :class="selectedElectrician === {{ $electrician->id }} ? 'border-amber-500 bg-amber-50' : 'border-gray-200'">
                                <div class="flex items-center space-x-4">
                                    <div class="h-12 w-12 rounded-full bg-amber-600 flex items-center justify-center text-white text-lg font-semibold flex-shrink-0">
                                        {{ substr($electrician->business_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $electrician->business_name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $electrician->years_experience }} years experience</p>
                                        <div class="flex items-center mt-1">
                                            <div class="flex text-amber-500">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= round($electrician->reviews_avg_rating ?? 0))
                                                        ★
                                                    @else
                                                        ☆
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="ml-2 text-xs text-gray-600">({{ $electrician->reviews_count ?? 0 }} reviews)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Step 2: Select Service -->
                <div class="mb-8" :class="selectedService ? 'opacity-50 pointer-events-none' : ''">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-amber-600 text-white text-xs flex items-center justify-center mr-2">2</span>
                        Choose a Service
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($services as $service)
                            <div @click="selectService({{ $service->id }})" 
                                class="p-4 border rounded-lg cursor-pointer hover:border-amber-500 transition"
                                :class="selectedService === {{ $service->id }} ? 'border-amber-500 bg-amber-50' : 'border-gray-200'">
                                <div class="flex justify-between items-start">
                                    <h3 class="font-semibold text-gray-900">{{ $service->name }}</h3>
                                    <span class="text-lg font-bold text-amber-600">${{ number_format($service->base_price, 2) }}</span>
                                </div>
                                <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $service->description }}</p>
                                <p class="text-xs text-gray-400 mt-2">{{ $service->estimated_duration_minutes }} minutes</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Step 3: Date & Time -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-amber-600 text-white text-xs flex items-center justify-center mr-2">3</span>
                        Select Date & Time
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Date</label>
                            <input type="date" 
                                x-model="selectedDate" 
                                @change="loadTimeSlots" 
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 px-3 py-2"
                                required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Time</label>
                            <select x-model="selectedSlot" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 px-3 py-2"
                                    :disabled="!timeSlots.length || loading"
                                    required>
                                <option value="">Select a time slot</option>
                                <template x-for="slot in timeSlots" :key="slot.id">
                                    <option :value="slot.id" x-text="slot.formatted_time"></option>
                                </template>
                            </select>
                            <div x-show="loading" class="mt-2 text-sm text-gray-500">
                                <span class="inline-flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Loading available slots...
                                </span>
                            </div>
                            <div x-show="!loading && timeSlots.length === 0 && selectedDate" class="mt-2 text-sm text-amber-600">
                                No available slots for this date
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Job Details -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <span class="w-6 h-6 rounded-full bg-amber-600 text-white text-xs flex items-center justify-center mr-2">4</span>
                        Job Details
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Street Address</label>
                            <input type="text" 
                                x-model="formData.address"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 px-3 py-2"
                                placeholder="123 Main St"
                                required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                                <input type="text" 
                                    x-model="formData.city"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 px-3 py-2"
                                    placeholder="New York"
                                    required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Postal Code</label>
                                <input type="text" 
                                    x-model="formData.postal_code"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 px-3 py-2"
                                    placeholder="10001"
                                    required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Job Description</label>
                            <textarea x-model="formData.description" 
                                    rows="4"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 px-3 py-2"
                                    placeholder="Describe the electrical work needed..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-between pt-6 border-t">
                    <a href="{{ route('bookings.create') }}" 
                    class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                        Start Over
                    </a>
                    <button type="submit" 
                            class="px-8 py-2 bg-gradient-to-r from-amber-600 to-amber-700 text-white rounded-md hover:from-amber-700 hover:to-amber-800 transition font-semibold shadow-md"
                            :disabled="!isFormValid">
                        Confirm Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('bookingForm', () => ({
        // State
        selectedElectrician: {{ $selectedElectrician->id ?? 'null' }},
        selectedService: {{ $selectedService->id ?? 'null' }},
        selectedDate: '',
        selectedSlot: '',
        timeSlots: [],
        loading: false,
        errors: [],
        formData: {
            description: '',
            address: '',
            city: '',
            postal_code: ''
        },

        // Computed Properties
        get isFormValid() {
            return this.selectedElectrician &&
                   this.selectedService &&
                   this.selectedDate &&
                   this.selectedSlot &&
                   this.formData.address &&
                   this.formData.city &&
                   this.formData.postal_code;
        },

        // Methods
        init() {
            console.log('Booking form initialized');
            if (this.selectedElectrician && this.selectedDate) {
                this.loadTimeSlots();
            }
        },

        selectElectrician(id) {
            if (!this.selectedElectrician) {
                this.selectedElectrician = id;
                console.log('Selected electrician:', id);
                if (this.selectedDate) {
                    this.loadTimeSlots();
                }
            }
        },

        selectService(id) {
            if (!this.selectedService) {
                this.selectedService = id;
                console.log('Selected service:', id);
            }
        },

        async loadTimeSlots() {
            if (!this.selectedElectrician || !this.selectedDate) return;
            
            this.loading = true;
            this.timeSlots = [];
            this.selectedSlot = '';

            try {
                const response = await fetch(`/api/available-slots?electrician_id=${this.selectedElectrician}&date=${this.selectedDate}`);
                const data = await response.json();
                this.timeSlots = Array.isArray(data) ? data : [];
                console.log('Loaded slots:', this.timeSlots.length);
            } catch(e) { 
                this.errors.push('Failed to load time slots'); 
                console.error(e); 
            }
            this.loading = false;
        },

        validateForm() {
            this.errors = [];
            if (!this.selectedElectrician) this.errors.push("Please select an electrician");
            if (!this.selectedService) this.errors.push("Please select a service");
            if (!this.selectedDate) this.errors.push("Please select a date");
            if (!this.selectedSlot) this.errors.push("Please select a time slot");
            if (!this.formData.address) this.errors.push("Please enter your street address");
            if (!this.formData.city) this.errors.push("Please enter your city");
            if (!this.formData.postal_code) this.errors.push("Please enter your postal code");
            
            return this.errors.length === 0;
        },

        submitForm(e) {
            e.preventDefault(); // Prevent default form submission
            
            if (!this.validateForm()) {
                window.scrollTo({ top: 0, behavior: 'smooth' });
                return;
            }
            
            // Submit the form programmatically
            document.getElementById('bookingForm').submit();
        }
    }))
})
</script>
@endsection