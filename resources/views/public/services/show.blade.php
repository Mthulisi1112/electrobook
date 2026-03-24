@extends('layouts.app')

@section('content')
<div class="bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        
        <!-- Breadcrumb -->
        <div class="flex items-center text-xs text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-gray-700">Thumbtack</a>
            <svg class="w-3 h-3 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('services.index') }}" class="hover:text-gray-700">Services</a>
            <svg class="w-3 h-3 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('service.electricians', ['service' => $service->slug]) }}" class="hover:text-gray-700">{{ $service->name }}</a>
            <svg class="w-3 h-3 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="font-medium text-gray-700">Overview</span>
        </div>

        <!-- Hero Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-light text-gray-900 mb-3">{{ $service->name }}</h1>
            <p class="text-sm text-gray-600 max-w-3xl leading-relaxed">
                {{ $service->description }}
            </p>
            
            <!-- CTA Button -->
            <div class="mt-4">
                <a href="{{ route('service.electricians', ['service' => $service->slug]) }}" 
                   class="inline-flex items-center px-6 py-3 bg-[#1e3a5f] text-white font-medium rounded-lg hover:bg-[#2b4c7c] transition">
                    Find {{ $service->name }} professionals near you
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
            
            <!-- Electrical Services Column -->
            <div>
                <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Related Services</h2>
                <div class="space-y-3">
                    @foreach($relatedServices as $related)
                        <a href="{{ route('service.electricians', ['service' => $related->slug]) }}" 
                           class="block text-sm text-gray-700 hover:text-gray-900 hover:underline">
                            {{ $related->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Common Requests Column -->
            <div>
                <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Common Requests</h2>
                <div class="space-y-3">
                    <a href="{{ route('service.electricians', ['service' => $service->slug, 'type' => 'installation']) }}" 
                       class="block text-sm text-gray-700 hover:text-gray-900 hover:underline">
                        {{ $service->name }} Installation
                    </a>
                    <a href="{{ route('service.electricians', ['service' => $service->slug, 'type' => 'repair']) }}" 
                       class="block text-sm text-gray-700 hover:text-gray-900 hover:underline">
                        {{ $service->name }} Repair
                    </a>
                    <a href="{{ route('service.electricians', ['service' => $service->slug, 'type' => 'maintenance']) }}" 
                       class="block text-sm text-gray-700 hover:text-gray-900 hover:underline">
                        {{ $service->name }} Maintenance
                    </a>
                    <a href="{{ route('service.electricians', ['service' => $service->slug, 'emergency' => true]) }}" 
                       class="block text-sm text-gray-700 hover:text-gray-900 hover:underline">
                        Emergency {{ $service->name }}
                    </a>
                </div>
            </div>

            <!-- Why Choose Us Column -->
            <div>
                <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Why Choose Us</h2>
                <div class="space-y-3">
                    <p class="text-sm text-gray-600">✓ Verified & licensed professionals</p>
                    <p class="text-sm text-gray-600">✓ Transparent pricing</p>
                    <p class="text-sm text-gray-600">✓ Satisfaction guaranteed</p>
                    <p class="text-sm text-gray-600">✓ 24/7 emergency service</p>
                </div>
            </div>
        </div>

        <!-- Popular services tags -->
        <div class="mt-12 pt-8 border-t border-gray-100">
            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Popular {{ $service->name }} requests</h3>
            <div class="flex flex-wrap gap-2">
                @php
                    $popularTags = [
                        'Emergency ' . $service->name,
                        $service->name . ' installation',
                        $service->name . ' repair',
                        $service->name . ' maintenance',
                        '24/7 ' . $service->name,
                        'Licensed ' . $service->name . ' pro',
                        $service->name . ' inspection',
                        'Residential ' . $service->name,
                        'Commercial ' . $service->name
                    ];
                @endphp
                
                @foreach($popularTags as $tag)
                    <a href="{{ route('service.electricians', ['service' => $service->slug, 'search' => $tag]) }}" 
                       class="px-3 py-1.5 bg-gray-50 hover:bg-gray-100 text-xs text-gray-600 rounded-full transition">
                        {{ $tag }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Top Rated Electricians Preview -->
        @if(isset($service->electricians) && $service->electricians->count() > 0)
        <div class="mt-12">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-light text-gray-900">Top-rated {{ $service->name }} professionals</h3>
                <a href="{{ route('service.electricians', ['service' => $service->slug]) }}" 
                   class="text-sm text-[#1e3a5f] hover:underline">
                    View all →
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($service->electricians->take(2) as $electrician)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                            @if($electrician->user && $electrician->user->profile_photo_path)
                                <img src="{{ Storage::url($electrician->user->profile_photo_path) }}" 
                                     alt="{{ $electrician->user->name }}"
                                     class="w-12 h-12 rounded-full object-cover">
                            @else
                                <span class="text-lg text-gray-400">{{ substr($electrician->user->name ?? 'P', 0, 1) }}</span>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-900">{{ $electrician->user->name ?? 'Professional' }}</h4>
                            <div class="flex items-center mt-1">
                                <span class="text-xs font-medium text-gray-900 mr-1">{{ number_format($electrician->reviews_avg_rating ?? 4.8, 1) }}</span>
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-3 h-3 {{ $i <= round($electrician->reviews_avg_rating ?? 4.8) ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-xs text-gray-500 ml-1">({{ $electrician->reviews_count ?? 0 }})</span>
                            </div>
                        </div>
                        <a href="{{ route('electricians.show', $electrician) }}" class="text-xs text-[#1e3a5f] hover:underline">
                            View
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection