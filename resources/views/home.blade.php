@extends('layouts.app')

@section('title', 'ElectroBook - Find Trusted Electricians')

@section('content')
<!-- Hero Section with Yellowish-Grey Background -->
<div class="relative overflow-hidden" style="background: linear-gradient(135deg, #f5f0e6 0%, #e8e0d3 50%, #d9cfbf 100%);">
    <!-- Subtle electrical pattern overlay -->
    <div class="absolute inset-0 opacity-5" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cpath d=\"M30 0 L30 60 M0 30 L60 30 M15 15 L45 45 M45 15 L15 45\" stroke=\"%236b5a3a\" stroke-width=\"0.5\" fill=\"none\"/%3E%3C/svg%3E'); background-repeat: repeat;"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <div class="text-center max-w-3xl mx-auto">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-800 mb-6">
                    Find the right 
                    <span class="text-amber-600 relative inline-block min-w-[200px]">
                        <span id="animated-word" class="inline-block transition-all duration-500"></span>
                    </span> 
                    <br class="hidden sm:block">
                    for your home
                </h1>
                <p class="text-lg md:text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                    Browse trusted professionals, compare prices, and book instantly.
                </p>
            </div>
            <!-- Search Bar -->
            <form action="{{ route('search') }}" method="GET" class="bg-white p-2 rounded-xl shadow-lg border border-gray-200 max-w-2xl mx-auto">
                <div class="flex flex-col sm:flex-row">
                    <input type="text" 
                        name="q"
                        placeholder="What electrical service do you need?" 
                        class="flex-1 px-4 py-3 border-0 focus:outline-none text-gray-700 rounded-lg">
                    <button type="submit" class="sm:ml-2 px-6 py-3 bg-amber-600 text-white font-medium rounded-lg hover:bg-amber-700 transition">
                        Search
                    </button>
                </div>
            </form>
                        
            <!-- Popular searches -->
            <div class="flex flex-wrap justify-center gap-2 mt-6">
                <a href="#" class="text-sm text-gray-700 hover:text-amber-600 px-3 py-1 bg-white/80 rounded-full">Emergency repair</a>
                <a href="#" class="text-sm text-gray-700 hover:text-amber-600 px-3 py-1 bg-white/80 rounded-full">Lighting installation</a>
                <a href="#" class="text-sm text-gray-700 hover:text-amber-600 px-3 py-1 bg-white/80 rounded-full">Panel upgrade</a>
                <a href="#" class="text-sm text-gray-700 hover:text-amber-600 px-3 py-1 bg-white/80 rounded-full">Outlet repair</a>
            </div>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="border-y border-gray-200 bg-white/80 backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <p class="text-3xl font-bold text-amber-600">500+</p>
                <p class="text-sm text-gray-600">Verified electricians</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-bold text-amber-600">10k+</p>
                <p class="text-sm text-gray-600">Jobs completed</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-bold text-amber-600">4.8/5</p>
                <p class="text-sm text-gray-600">Average rating</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-bold text-amber-600">24/7</p>
                <p class="text-sm text-gray-600">Emergency service</p>
            </div>
        </div>
    </div>
</div>

<!-- How It Works with Images -->
<div id="how-it-works" class="py-16" style="background: linear-gradient(135deg, #f5f0e6 0%, #e8e0d3 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">How it works</h2>
            <p class="text-lg text-gray-600">Three simple steps to get your electrical work done</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Step 1 -->
            <div class="text-center group">
                <div class="relative w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden shadow-lg group-hover:scale-105 transition-transform">
                    <img src="https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&h=200&q=80" 
                         alt="Describe project" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-amber-600/20"></div>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-800">Tell us what you need</h3>
                <p class="text-gray-600">Describe your electrical project and we'll match you with qualified pros.</p>
            </div>
            <!-- Step 2 -->
            <div class="text-center group">
                <div class="relative w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden shadow-lg group-hover:scale-105 transition-transform">
                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&h=200&q=80" 
                         alt="Compare professionals" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-amber-600/20"></div>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-800">Compare & choose</h3>
                <p class="text-gray-600">Review profiles, ratings, and prices to find the perfect electrician.</p>
            </div>
            <!-- Step 3 -->
            <div class="text-center group">
                <div class="relative w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden shadow-lg group-hover:scale-105 transition-transform">
                    <img src="https://images.unsplash.com/photo-1621905252507-b35492cc74b4?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&h=200&q=80" 
                         alt="Job completed" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-amber-600/20"></div>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-800">Book & get it done</h3>
                <p class="text-gray-600">Schedule a time that works for you and get your problem solved.</p>
            </div>
        </div>
    </div>
</div>

<!-- Popular Services with Category Images -->
<div class="py-16 bg-white/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Popular electrical services</h2>
            <a href="{{ route('services.index') }}" class="text-amber-600 hover:text-amber-700 font-medium flex items-center">
                View all services
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="#" class="relative group overflow-hidden rounded-xl">
                <img src="https://images.unsplash.com/photo-1621905252507-b35492cc74b4?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=300&q=80" 
                     alt="Emergency Repair" 
                     class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-4">
                    <svg class="w-8 h-8 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span class="text-white font-semibold block">Emergency Repair</span>
                </div>
            </a>
            <a href="#" class="relative group overflow-hidden rounded-xl">
                <img src="https://images.unsplash.com/photo-1581094288338-2314dddb7ece?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=300&q=80" 
                     alt="Panel Upgrade" 
                     class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-4">
                    <svg class="w-8 h-8 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-white font-semibold block">Panel Upgrade</span>
                </div>
            </a>
            <a href="#" class="relative group overflow-hidden rounded-xl">
                <img src="https://images.unsplash.com/photo-1567427017947-545c5f8d16ad?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=300&q=80" 
                     alt="Lighting Installation" 
                     class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-4">
                    <svg class="w-8 h-8 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0114 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                    <span class="text-white font-semibold block">Lighting Installation</span>
                </div>
            </a>
            <a href="#" class="relative group overflow-hidden rounded-xl">
                <img src="https://images.unsplash.com/photo-1621905251189-08b45d6a269e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=300&q=80" 
                     alt="Wiring & Rewiring" 
                     class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-4">
                    <svg class="w-8 h-8 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-white font-semibold block">Wiring & Rewiring</span>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Featured Electricians -->
<div class="py-16" style="background: linear-gradient(135deg, #f5f0e6 0%, #e8e0d3 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Featured electricians</h2>
            <a href="{{ route('electricians.index') }}" class="text-amber-600 hover:text-amber-700 font-medium flex items-center">
                View all
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        
        @php
            $featuredElectricians = App\Models\Electrician::with('user')
                ->where('is_verified', true)
                ->withCount('reviews')
                ->withAvg('reviews', 'rating')
                ->orderBy('reviews_avg_rating', 'desc')
                ->limit(4)
                ->get();
        @endphp
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($featuredElectricians as $index => $electrician)
                <a href="{{ route('electricians.show', $electrician) }}" class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group">
                    <div class="relative h-32 bg-gradient-to-r from-amber-600 to-amber-700">
                        <div class="absolute -bottom-10 left-1/2 transform -translate-x-1/2">
                            <div class="w-20 h-20 rounded-full border-4 border-white bg-white overflow-hidden shadow-lg">
                                @php
                                    $businessName = $electrician->business_name ?? 'Electrician';
                                    $initials = '';
                                    $nameParts = explode(' ', $businessName);
                                    foreach ($nameParts as $part) {
                                        if (!empty($part)) {
                                            $initials .= strtoupper(substr($part, 0, 1));
                                        }
                                    }
                                    if (empty($initials)) {
                                        $initials = strtoupper(substr($businessName, 0, 1));
                                    }
                                    $avatarUrl = "https://ui-avatars.com/api/?background=amber-600&color=fff&bold=true&size=128&name=" . urlencode($initials);
                                @endphp
                                
                                @if($electrician->user && $electrician->user->profile_photo_path && !str_contains($electrician->user->profile_photo_path, 'ui-avatars.com'))
                                    <img src="{{ $electrician->user->profile_photo_path }}" 
                                         alt="{{ $electrician->business_name }}" 
                                         class="w-full h-full object-cover"
                                         onerror="this.onerror=null; this.src='{{ $avatarUrl }}'">
                                @else
                                    <img src="{{ $avatarUrl }}" 
                                         alt="{{ $electrician->business_name }}" 
                                         class="w-full h-full object-cover">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="pt-12 p-5 text-center">
                        <h3 class="font-semibold text-gray-800 mb-1">{{ $electrician->business_name }}</h3>
                        <p class="text-sm text-gray-500 mb-3">{{ $electrician->years_experience }} years exp.</p>
                        
                        <div class="flex items-center justify-center mb-3">
                            <div class="flex text-amber-500">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($electrician->reviews_avg_rating ?? 0))
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">★</svg>
                                    @else
                                        <svg class="w-4 h-4 fill-current text-gray-300" viewBox="0 0 20 20">★</svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500 ml-2">({{ $electrician->reviews_count ?? 0 }})</span>
                        </div>
                        
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $electrician->bio ?? 'Professional electrician' }}</p>
                        
                        <div class="text-amber-600 font-bold text-lg">
                            ${{ number_format($electrician->hourly_rate ?? 85, 0) }}<span class="text-sm font-normal text-gray-500">/hr</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-4 text-center text-gray-500 py-8">
                    No featured electricians available at the moment.
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Why Choose Us with Images -->
<div class="py-16 bg-white/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Why customers love ElectroBook</h2>
            <p class="text-lg text-gray-600">Thousands of satisfied customers trust us with their electrical needs</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center group">
                <div class="relative w-24 h-24 mx-auto mb-4 rounded-full overflow-hidden shadow-md group-hover:shadow-xl transition-shadow">
                    <img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&h=200&q=80" 
                         alt="Verified professionals" 
                         class="w-full h-full object-cover">
                </div>
                <h3 class="font-semibold text-lg mb-2 text-gray-800">Verified professionals</h3>
                <p class="text-gray-600">Every electrician is licensed, insured, and background-checked.</p>
            </div>
            
            <div class="text-center group">
                <div class="relative w-24 h-24 mx-auto mb-4 rounded-full overflow-hidden shadow-md group-hover:shadow-xl transition-shadow">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&h=200&q=80" 
                         alt="Instant booking" 
                         class="w-full h-full object-cover">
                </div>
                <h3 class="font-semibold text-lg mb-2 text-gray-800">Instant booking</h3>
                <p class="text-gray-600">Book appointments instantly with real-time availability.</p>
            </div>
            
            <div class="text-center group">
                <div class="relative w-24 h-24 mx-auto mb-4 rounded-full overflow-hidden shadow-md group-hover:shadow-xl transition-shadow">
                    <img src="https://images.unsplash.com/photo-1556741533-6e6a62bd8b49?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&h=200&q=80" 
                         alt="Satisfaction guaranteed" 
                         class="w-full h-full object-cover">
                </div>
                <h3 class="font-semibold text-lg mb-2 text-gray-800">Satisfaction guaranteed</h3>
                <p class="text-gray-600">Not happy? We'll work to make it right.</p>
            </div>
        </div>
    </div>
</div>

<!-- Customer Testimonials -->
<div class="py-16" style="background: linear-gradient(135deg, #f5f0e6 0%, #e8e0d3 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">What our customers say</h2>
            <p class="text-lg text-gray-600">Real stories from real customers</p>
        </div>
        
        @php
            // Get latest 3 reviews with their clients and electricians
            $testimonials = App\Models\Review::with(['client', 'electrician'])
                ->whereNotNull('comment')
                ->where('comment', '!=', '')
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();
            
            // If less than 3 reviews, get additional random ones
            if($testimonials->count() < 3) {
                $additional = App\Models\Review::with(['client', 'electrician'])
                    ->whereNotNull('comment')
                    ->where('comment', '!=', '')
                    ->whereNotIn('id', $testimonials->pluck('id'))
                    ->inRandomOrder()
                    ->limit(3 - $testimonials->count())
                    ->get();
                $testimonials = $testimonials->concat($additional);
            }
        @endphp
        
        @if($testimonials->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($testimonials as $review)
                    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition group">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-200 shadow-sm mr-4 flex-shrink-0">
                                @php
                                    $clientName = $review->client->name ?? 'Customer';
                                    $initials = '';
                                    $nameParts = explode(' ', $clientName);
                                    foreach ($nameParts as $part) {
                                        if (!empty($part)) {
                                            $initials .= strtoupper(substr($part, 0, 1));
                                        }
                                    }
                                    if (empty($initials)) {
                                        $initials = strtoupper(substr($clientName, 0, 1));
                                    }
                                    $avatarUrl = "https://ui-avatars.com/api/?background=6b7280&color=fff&bold=true&size=128&name=" . urlencode($initials);
                                @endphp
                                
                                @if($review->client && $review->client->profile_photo_path && !str_contains($review->client->profile_photo_path, 'ui-avatars.com'))
                                    <img src="{{ $review->client->profile_photo_path }}" 
                                         alt="{{ $clientName }}" 
                                         class="w-full h-full object-cover"
                                         onerror="this.onerror=null; this.src='{{ $avatarUrl }}'">
                                @else
                                    <img src="{{ $avatarUrl }}" 
                                         alt="{{ $clientName }}" 
                                         class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">{{ $clientName }}</h4>
                                <div class="flex items-center">
                                    <div class="flex text-amber-500 text-sm">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">★</svg>
                                            @else
                                                <svg class="w-4 h-4 fill-current text-gray-300" viewBox="0 0 20 20">★</svg>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-xs text-gray-500 ml-2">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600 italic line-clamp-3">"{{ $review->comment }}"</p>
                        @if($review->electrician)
                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <p class="text-xs text-gray-400">
                                    Service by: 
                                    <span class="text-amber-600 font-medium">{{ $review->electrician->business_name }}</span>
                                </p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="bg-white rounded-xl p-8 max-w-md mx-auto">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">No reviews yet</h3>
                    <p class="text-gray-500 text-sm">Be the first to leave a review for our electricians!</p>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- FAQ Preview -->
<div id="faq" class="py-16 bg-white/80">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-8">Frequently asked questions</h2>
        
        <div class="space-y-3">
            <div class="bg-white rounded-lg border border-gray-200" x-data="{ open: false }">
                <button @click="open = !open" class="flex justify-between items-center w-full px-6 py-4">
                    <span class="font-medium text-gray-800">How do I book an electrician?</span>
                    <svg class="w-5 h-5 text-gray-500" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" class="px-6 pb-4 text-gray-600">
                    Simply search for the service you need, browse electricians in your area, check their reviews and rates, and book a time that works for you. You'll receive an instant confirmation.
                </div>
            </div>
            
            <div class="bg-white rounded-lg border border-gray-200" x-data="{ open: false }">
                <button @click="open = !open" class="flex justify-between items-center w-full px-6 py-4">
                    <span class="font-medium text-gray-800">Are electricians verified?</span>
                    <svg class="w-5 h-5 text-gray-500" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" class="px-6 pb-4 text-gray-600">
                    Yes, all electricians on our platform go through a thorough verification process including license checks, background screening, and identity verification.
                </div>
            </div>
            
            <div class="bg-white rounded-lg border border-gray-200" x-data="{ open: false }">
                <button @click="open = !open" class="flex justify-between items-center w-full px-6 py-4">
                    <span class="font-medium text-gray-800">What if I need emergency service?</span>
                    <svg class="w-5 h-5 text-gray-500" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" class="px-6 pb-4 text-gray-600">
                    Many of our electricians offer 24/7 emergency services. Look for the "Available now" badge or filter by emergency services to find help immediately.
                </div>
            </div>
        </div>
        
        <div class="text-center mt-8">
            <a href="#" class="text-amber-600 hover:text-amber-700 font-medium">
                View all FAQs →
            </a>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="relative bg-amber-700 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <img src="https://images.unsplash.com/photo-1581094288338-2314dddb7ece?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
             alt="Background" 
             class="w-full h-full object-cover">
    </div>
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Ready to get started?</h2>
        <p class="text-lg text-white/90 mb-8">Join thousands of satisfied customers who found their trusted electrician through ElectroBook.</p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('services.index') }}" class="px-6 py-3 bg-white text-amber-600 font-medium rounded-lg hover:bg-gray-100 transition">
                Find an electrician
            </a>
            @guest
                <a href="{{ route('register') }}" class="px-6 py-3 border border-white text-white font-medium rounded-lg hover:bg-white/10 transition">
                    Sign up as electrician
                </a>
            @endguest
        </div>
    </div>
</div>

<script>
    const words = ['electrician', 'plumber', 'painter', 'handyman', 'carpenter'];
    let wordIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    const typedWordSpan = document.getElementById('animated-word');

    function typeEffect() {
        const currentWord = words[wordIndex];
        
        if (isDeleting) {
            typedWordSpan.textContent = currentWord.substring(0, charIndex - 1);
            charIndex--;
        } else {
            typedWordSpan.textContent = currentWord.substring(0, charIndex + 1);
            charIndex++;
        }

        if (!isDeleting && charIndex === currentWord.length) {
            isDeleting = true;
            setTimeout(typeEffect, 2000);
        } else if (isDeleting && charIndex === 0) {
            isDeleting = false;
            wordIndex = (wordIndex + 1) % words.length;
            setTimeout(typeEffect, 500);
        } else {
            setTimeout(typeEffect, isDeleting ? 50 : 100);
        }
    }

    typeEffect();
</script>

@endsection