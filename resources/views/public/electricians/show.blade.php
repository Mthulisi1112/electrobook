@extends('layouts.app')

@section('title', $electrician->business_name . ' - ElectroBook')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Main Profile Card -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-8">
        <!-- Cover Photo -->
        <div class="h-32 bg-gradient-to-r from-[#1e3a5f] to-[#2b4c7c] relative">
            <div class="absolute inset-0 opacity-20">
                <img src="https://images.unsplash.com/photo-1581094288338-2314dddb7ece?w=1920&q=80" 
                     alt="Electrical work" 
                     class="w-full h-full object-cover">
            </div>
        </div>
        
        <div class="px-6 pb-6">
          

            <!-- Profile Header -->
            <div class="flex flex-col md:flex-row md:items-end  mb-6">
                <!-- Avatar -->
                <div class="flex-shrink-0">
                    @php
                        $hasPhoto = $electrician->user && $electrician->user->profile_photo_path && 
                                    filter_var($electrician->user->profile_photo_path, FILTER_VALIDATE_URL) &&
                                    !str_contains($electrician->user->profile_photo_path, 'ui-avatars.com');
                        $businessName = $electrician->business_name ?? 'E';
                        $initial = strtoupper(substr($businessName, 0, 1));
                    @endphp
                    
                    @if($hasPhoto)
                        <div class="h-24 w-24 rounded-xl border-4 border-white shadow-lg bg-white overflow-hidden">
                            <img src="{{ $electrician->user->profile_photo_path }}" 
                                alt="{{ $businessName }}" 
                                class="w-full h-full object-cover"
                                onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\"h-full w-full bg-[#1e3a5f] flex items-center justify-center text-white text-3xl font-bold\">{{ $initial }}>
                        </div>
    
                    @else
                        <div class="h-24 w-24 rounded-xl border-4 border-white shadow-lg bg-[#1e3a5f] flex items-center justify-center text-white text-3xl font-bold">
                            {{ $initial }}
                        </div>
                    @endif
                </div>
                
                <!-- Name and Actions -->
                <div class="flex-1 mt-4 md:mt-0 md:ml-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $electrician->business_name }}</h1>
                            <p class="text-gray-500 mt-1">{{ $electrician->user->name ?? 'Professional Electrician' }}</p>
                            
                            <!-- Rating -->
                            <div class="flex items-center mt-2">
                                <div class="flex text-amber-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($ratings['average'] ?? 0))
                                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">★</svg>
                                        @else
                                            <svg class="w-5 h-5 fill-current text-gray-300" viewBox="0 0 20 20">★</svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="ml-2 text-sm text-gray-600">
                                    {{ number_format($ratings['average'] ?? 0, 1) }} ({{ $ratings['total'] ?? 0 }} reviews)
                                </span>
                                @if($electrician->is_verified)
                                    <span class="ml-3 inline-flex items-center gap-1 px-2 py-1 bg-green-50 text-green-700 text-xs rounded-full">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Verified
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex gap-3 mt-4 lg:mt-0">
                            <a href="{{ route('bookings.create', ['electrician_id' => $electrician->id]) }}" 
                               class="px-5 py-2.5 bg-[#1e3a5f] text-white text-sm font-medium rounded-lg hover:bg-[#2b4c7c] transition inline-flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                BOOK NOW
                            </a>
                            <a href="{{ route('contact')}}" 
                               class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition inline-flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                CONTACT
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - 2/3 -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- About -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">About</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $electrician->bio ?? 'No bio provided.' }}</p>
                    </div>

                    <!-- Projects & Portfolio Section -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Projects & portfolio</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <!-- Project 1 -->
                            <div class="group relative overflow-hidden rounded-lg aspect-square cursor-pointer">
                                <img src="https://images.unsplash.com/photo-1621905252507-b35492cc74b4?w=400&h=400&fit=crop" 
                                     alt="Electrical panel installation" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                                    <div class="absolute bottom-0 left-0 right-0 p-3">
                                        <p class="text-white text-xs font-medium">Panel Upgrade</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Project 2 -->
                            <div class="group relative overflow-hidden rounded-lg aspect-square cursor-pointer">
                                <img src="https://images.unsplash.com/photo-1581094288338-2314dddb7ece?w=400&h=400&fit=crop" 
                                     alt="Wiring installation" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                                    <div class="absolute bottom-0 left-0 right-0 p-3">
                                        <p class="text-white text-xs font-medium">Wiring Installation</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Project 3 -->
                            <div class="group relative overflow-hidden rounded-lg aspect-square cursor-pointer">
                                <img src="https://images.unsplash.com/photo-1567427017947-545c5f8d16ad?w=400&h=400&fit=crop" 
                                     alt="Lighting installation" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                                    <div class="absolute bottom-0 left-0 right-0 p-3">
                                        <p class="text-white text-xs font-medium">Smart Lighting</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Project 4 -->
                            <div class="group relative overflow-hidden rounded-lg aspect-square cursor-pointer">
                                <img src="https://images.unsplash.com/photo-1558449028-b53a39d100fc?w=400&h=400&fit=crop" 
                                     alt="Electrical panel" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                                    <div class="absolute bottom-0 left-0 right-0 p-3">
                                        <p class="text-white text-xs font-medium">Panel Installation</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Project 5 -->
                            <div class="group relative overflow-hidden rounded-lg aspect-square cursor-pointer">
                                <img src="https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?w=400&h=400&fit=crop" 
                                     alt="Electrician at work" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                                    <div class="absolute bottom-0 left-0 right-0 p-3">
                                        <p class="text-white text-xs font-medium">Emergency Repair</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Project 6 -->
                            <div class="group relative overflow-hidden rounded-lg aspect-square cursor-pointer">
                                <img src="https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?w=400&h=400&fit=crop" 
                                     alt="Safety inspection" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                                    <div class="absolute bottom-0 left-0 right-0 p-3">
                                        <p class="text-white text-xs font-medium">Safety Inspection</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 text-center">
                            <button class="text-sm text-[#1e3a5f] hover:text-[#2b4c7c] font-medium inline-flex items-center">
                                View all projects
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Services -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">Services & pricing</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($servicePricing as $service)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                    <h3 class="font-semibold text-gray-900">{{ $service->name }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ $service->duration }} minutes</p>
                                    <p class="text-lg font-bold text-[#1e3a5f] mt-2">${{ number_format($service->electrician_price, 2) }}</p>
                                </div>
                            @empty
                                <p class="text-gray-500 col-span-2 text-center py-8">No services listed.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Reviews -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">Client reviews</h2>
                        
                        @if($electrician->reviews->isNotEmpty())
                            <div class="space-y-6">
                                @foreach($electrician->reviews as $review)
                                    <div class="border-b border-gray-200 last:border-0 pb-6">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                @php
                                                    $clientAvatar = "https://ui-avatars.com/api/?background=6b7280&color=fff&bold=true&size=128&name=" . urlencode($review->client->name);
                                                @endphp
                                                <div class="h-10 w-10 rounded-full overflow-hidden bg-gray-200">
                                                    <img src="{{ $clientAvatar }}" 
                                                         alt="{{ $review->client->name }}" 
                                                         class="w-full h-full object-cover">
                                                </div>
                                            </div>
                                            <div class="ml-4 flex-1">
                                                <div class="flex items-center justify-between">
                                                    <h3 class="text-sm font-medium text-gray-900">{{ $review->client->name }}</h3>
                                                    <p class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                                                </div>
                                                <div class="flex text-amber-400 mt-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">★</svg>
                                                        @else
                                                            <svg class="w-4 h-4 fill-current text-gray-300" viewBox="0 0 20 20">★</svg>
                                                        @endif
                                                    @endfor
                                                </div>
                                                @if($review->comment)
                                                    <p class="mt-2 text-sm text-gray-600">"{{ $review->comment }}"</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12 bg-gray-50 rounded-lg">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.364 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.364-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No reviews yet.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column - 1/3 Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Quick Info Card -->
                    <div class="bg-gray-50 rounded-xl p-5">
                        <h3 class="font-semibold text-gray-900 mb-3">Quick info</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-center">
                                <span class="w-24 text-gray-500">Experience:</span>
                                <span class="font-medium text-gray-900">{{ $electrician->years_experience }} years</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-24 text-gray-500">Hourly rate:</span>
                                <span class="font-medium text-[#1e3a5f]">${{ number_format($electrician->hourly_rate, 2) }}</span>
                            </div>
                            @if($electrician->license_number)
                                <div class="flex items-center">
                                    <span class="w-24 text-gray-500">License:</span>
                                    <span class="font-mono text-xs bg-white px-2 py-1 rounded">{{ $electrician->license_number }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Rating Distribution -->
                    <div class="bg-gray-50 rounded-xl p-5">
                        <h3 class="font-semibold text-gray-900 mb-3">Rating breakdown</h3>
                        @php
                            $total = $ratings['total'];
                            $distribution = $ratings['distribution'];
                        @endphp
                        <div class="space-y-2">
                            @foreach([5,4,3,2,1] as $star)
                                @php
                                    $count = $distribution[$star] ?? 0;
                                    $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                                @endphp
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-500 w-8">{{ $star }}★</span>
                                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-amber-400 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span class="text-xs text-gray-500 w-8 text-right">{{ $count }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Service Areas -->
                    @php
                        $serviceAreas = is_string($electrician->service_areas) 
                            ? json_decode($electrician->service_areas, true) 
                            : $electrician->service_areas;
                    @endphp
                    
                    @if($serviceAreas && count($serviceAreas) > 0)
                        <div class="bg-gray-50 rounded-xl p-5">
                            <h3 class="font-semibold text-gray-900 mb-3">Service areas</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($serviceAreas as $area)
                                    <span class="px-3 py-1 bg-white text-gray-600 text-xs rounded-full border border-gray-200">{{ $area }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Contact -->
                    <div class="bg-gray-50 rounded-xl p-5">
                        <h3 class="font-semibold text-gray-900 mb-3">Contact</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <a href="mailto:{{ $electrician->user->email }}" class="text-[#1e3a5f] hover:underline">
                                    {{ $electrician->user->email }}
                                </a>
                            </div>
                            @if($electrician->phone)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span class="text-gray-700">{{ $electrician->phone }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Availability Calendar -->
                    <x-public.availability-calendar :availableSlots="$availableSlots" :electrician="$electrician" />
                </div>
            </div>
        </div>
    </div>

    <!-- Similar Electricians -->
    @if($similarElectricians->isNotEmpty())
        <div class="mt-12">
            <h2 class="text-xl font-bold text-gray-900 mb-6">You might also like</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($similarElectricians as $similar)
                    <a href="{{ route('electricians.show', $similar) }}" class="bg-white rounded-xl border border-gray-200 p-4 hover:shadow-md transition group">
                        <div class="flex items-center gap-3 mb-3">
                            @php
                                $similarName = $similar->business_name ?? 'E';
                                $similarInitial = strtoupper(substr($similarName, 0, 1));
                            @endphp
                            <div class="w-12 h-12 rounded-full bg-[#1e3a5f] flex items-center justify-center text-white font-bold text-lg">
                                {{ $similarInitial }}
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">{{ $similarName }}</h4>
                                <div class="flex items-center text-sm">
                                    <div class="flex text-amber-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= round($similar->reviews_avg_rating ?? 0))
                                                ★
                                            @else
                                                ☆
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-xs text-gray-500 ml-1">({{ $similar->reviews_count ?? 0 }})</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold text-[#1e3a5f]">${{ number_format($similar->hourly_rate, 0) }}/hr</span>
                            <span class="text-sm text-gray-400 group-hover:text-[#1e3a5f] transition-colors">
                                View →
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Booking CTA -->
    <div class="mt-12 bg-gray-50 rounded-xl p-8 text-center">
        <h2 class="text-xl font-bold text-gray-900 mb-2">Ready to book {{ $electrician->business_name }}?</h2>
        <p class="text-gray-600 mb-6">Schedule your appointment now and get your electrical issues fixed.</p>
        <a href="{{ route('bookings.create', ['electrician_id' => $electrician->id]) }}" 
           class="inline-flex items-center px-6 py-3 bg-[#1e3a5f] text-white font-medium rounded-lg hover:bg-[#2b4c7c] transition">
            Book appointment
            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</div>
@endsection