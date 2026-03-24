@extends('layouts.app')

@section('content')
<div class="min-h-screen" style="background: linear-gradient(135deg, #f5f0e6 0%, #e8e0d3 50%, #d9cfbf 100%);">
    <!-- Hero Section with Background Image (Kept as is) -->
    <div class="relative overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=1920&q=80" 
                alt="Professional electrician working on electrical panel" 
                class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/50"></div>
            <div class="absolute inset-0 opacity-20" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cpath d=\"M30 0 L30 60 M0 30 L60 30 M15 15 L45 45 M45 15 L15 45\" stroke=\"white\" stroke-width=\"0.5\" fill=\"none\" opacity=\"0.3\"/%3E%3C/svg%3E'); background-repeat: repeat;"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="flex items-center text-xs text-gray-200 mb-6">
                <a href="{{ route('home') }}" class="hover:text-white transition">ElectroBook</a>
                <svg class="w-3 h-3 mx-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <a href="{{ route('services.show', $service) }}" class="hover:text-white transition">{{ $service->name }}</a>
                <svg class="w-3 h-3 mx-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="font-medium text-white">Electricians</span>
            </div>

            <div class="max-w-3xl">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 leading-tight">
                    {{ $service->name }} <span class="text-yellow-400">near you</span>
                </h1>
                <p class="text-lg md:text-xl text-gray-100 leading-relaxed mb-6">
                    {{ $service->description ?? 'Find trusted, licensed electricians in your area. Emergency repairs, installations, and upgrades - all backed by our satisfaction guarantee.' }}
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
            <div class="flex items-center space-x-2">
                <span class="text-xs text-gray-600">Sort by:</span>
                <a href="{{ route('service.electricians', [$service, 'sort' => 'rating']) }}" 
                   class="px-3 py-1 text-xs {{ request('sort') == 'rating' ? 'bg-amber-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-full transition">
                    Top rated
                </a>
                <a href="{{ route('service.electricians', [$service, 'sort' => 'reviews']) }}" 
                   class="px-3 py-1 text-xs {{ request('sort') == 'reviews' ? 'bg-amber-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-full transition">
                    Most reviews
                </a>
            </div>
            <span class="text-xs text-gray-600">{{ $electricians->total() }} electricians near you</span>
        </div>

        <div class="space-y-4">
            @foreach($electricians as $index => $electrician)
            <div class="relative border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-all duration-300 bg-white overflow-hidden group">
                <div class="absolute inset-0 opacity-0 group-hover:opacity-5 transition-opacity duration-300 pointer-events-none">
                    <img src="https://images.unsplash.com/photo-1581094288338-2314dddb7ece?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                         alt="Background" 
                         class="w-full h-full object-cover">
                </div>
                
                <div class="flex items-start justify-between relative z-10">
                    <div class="flex-1">
                        <!-- Profile Photo and Name Section -->
                        <div class="flex items-center space-x-3 mb-2">
                            <!-- Profile Photo - Using UI Avatars -->
                            <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-200 flex-shrink-0 shadow-sm">
                                @php
                                    $userName = $electrician->user->name ?? $electrician->business_name ?? 'Electrician';
                                    $initials = '';
                                    $nameParts = explode(' ', $userName);
                                    foreach ($nameParts as $part) {
                                        if (!empty($part)) {
                                            $initials .= strtoupper(substr($part, 0, 1));
                                        }
                                    }
                                    $avatarUrl = "https://ui-avatars.com/api/?background=1e3a5f&color=fff&bold=true&size=128&name=" . urlencode($initials);
                                @endphp
                                
                                @if($electrician->user && $electrician->user->profile_photo_path && !str_contains($electrician->user->profile_photo_path, 'ui-avatars.com'))
                                    <img src="{{ $electrician->user->profile_photo_path }}" 
                                         alt="{{ $userName }}" 
                                         class="w-full h-full object-cover"
                                         onerror="this.onerror=null; this.src='{{ $avatarUrl }}'">
                                @else
                                    <img src="{{ $avatarUrl }}" 
                                         alt="{{ $userName }}" 
                                         class="w-full h-full object-cover">
                                @endif
                            </div>
                            
                            <div>
                                <div class="flex items-center space-x-2">
                                    @if($index == 0)
                                        <span class="text-xs font-medium text-green-700 bg-green-50 px-2 py-0.5 rounded">⭐ Top Pro Exceptional</span>
                                    @endif
                                    <h2 class="text-lg font-medium text-gray-800">{{ $userName }}</h2>
                                </div>
                                @if($electrician->is_verified ?? true)
                                    <div class="flex items-center mt-0.5">
                                        <svg class="w-3.5 h-3.5 text-green-600 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-xs text-gray-500">Verified Professional</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Rating -->
                        <div class="flex items-center space-x-2 mb-2 ml-15">
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-gray-800">{{ number_format($electrician->reviews_avg_rating ?? 5.0, 1) }}</span>
                                <div class="flex items-center ml-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= round($electrician->reviews_avg_rating ?? 5) ? 'text-amber-500' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-xs text-gray-500 ml-1">({{ $electrician->reviews_count ?? 179 }})</span>
                            </div>
                        </div>

                        <!-- Services offered -->
                        <p class="text-sm text-gray-600 mb-3">
                            @foreach($electrician->services->take(4) as $serviceItem)
                                {{ $serviceItem->name }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </p>

                        <div class="flex items-center space-x-4 mb-3">
                            <span class="text-xs text-orange-600 bg-orange-50 px-2 py-0.5 rounded">📌 In high demand</span>
                        </div>

                        <div class="flex items-center space-x-4 mb-3 text-xs text-gray-600">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                👍 {{ $electrician->bookings_count ?? rand(50, 500) }} hires on ElectroBook
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                💬 {{ rand(1, 5) }} similar job{{ rand(1, 5) > 1 ? 's' : '' }} done near you
                            </span>
                        </div>

                        <!-- Fixed Review Section -->
                        <div class="mb-3 p-3 bg-amber-50 rounded-lg border-l-4 border-amber-600">
                            <p class="text-sm text-gray-700">
                                <svg class="w-4 h-4 text-gray-400 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                                </svg>
                                <span class="font-medium">{{ $electrician->reviews->first()->user->name ?? 'Recent customer' }} says,</span> 
                                "{{ \Illuminate\Support\Str::limit($electrician->reviews->first()->comment ?? 'Very capable electrician - would definitely hire again!', 100) }}"
                                
                                @php
                                    $firstReview = $electrician->reviews->first();
                                @endphp
                                
                                @if($firstReview)
                                    <a href="{{ route('reviews.show', $firstReview) }}" class="text-amber-600 hover:underline text-xs ml-1">See more</a>
                                @else
                                    <a href="#" class="text-amber-600 hover:underline text-xs ml-1">Read review</a>
                                @endif
                            </p>
                        </div>

                        <div class="text-sm">
                            <span class="font-bold text-lg text-amber-600">${{ $electrician->hourly_rate ?? 69 }}</span>
                            <span class="text-xs text-gray-500">/service call</span>
                            <span class="text-xs text-gray-500 ml-1 bg-gray-100 px-2 py-0.5 rounded">(waived if hired)</span>
                        </div>
                    </div>

                    <a href="{{ route('electricians.show', $electrician) }}" 
                       class="ml-6 px-6 py-2.5 bg-amber-600 text-white text-sm font-medium rounded-lg hover:bg-amber-700 hover:shadow-md transition-all whitespace-nowrap transform hover:scale-105">
                        View profile →
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $electricians->links() }}
        </div>
    </div>
</div>

<style>
    body {
        background: linear-gradient(135deg, #f5f0e6 0%, #e8e0d3 50%, #d9cfbf 100%);
    }
    
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .pagination .page-item .page-link {
        padding: 0.5rem 0.75rem;
        borderRadius: 0.5rem;
        color: #374151;
        transition: all 0.2s;
        background-color: white;
        border: 1px solid #e5e7eb;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #d97706;
        color: white;
        border-color: #d97706;
    }
    
    .pagination .page-item .page-link:hover {
        background-color: #fef3c7;
        transform: translateY(-1px);
    }
    
    .ml-15 {
        margin-left: 3.75rem;
    }
</style>
@endsection