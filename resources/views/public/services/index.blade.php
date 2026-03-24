@extends('layouts.app')

@section('title', 'Electrical Services - ElectroBook')

@section('content')
<!-- Hero Section with Yellowish-Grey Background -->
<div class="relative overflow-hidden" style="background: linear-gradient(135deg, #f5f0e6 0%, #e8e0d3 50%, #d9cfbf 100%);">
    <!-- Subtle electrical pattern overlay -->
    <div class="absolute inset-0 opacity-5" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cpath d=\"M30 0 L30 60 M0 30 L60 30 M15 15 L45 45 M45 15 L15 45\" stroke=\"%236b5a3a\" stroke-width=\"0.5\" fill=\"none\"/%3E%3C/svg%3E'); background-repeat: repeat;"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">
                Electrical services for every need
            </h1>
            <p class="text-lg text-gray-600 mb-6">
                Find licensed electricians for installations, repairs, and maintenance. All professionals are verified.
            </p>
            
            <!-- Search Bar -->
            <div class="bg-white p-1 rounded-xl shadow-sm border border-gray-200 max-w-xl mx-auto">
                <form action="{{ route('services.index') }}" method="GET" class="flex">
                    <input type="text" 
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search for electrical services..." 
                           class="flex-1 px-4 py-2.5 border-0 focus:outline-none text-gray-700 rounded-l-lg">
                    <button type="submit" class="px-6 py-2.5 bg-amber-600 text-white font-medium rounded-r-lg hover:bg-amber-700 transition">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Category Pills - Now linking to electricians pages -->
<div class="border-b border-gray-200 bg-white/80 backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex overflow-x-auto py-4 gap-2 no-scrollbar">
            <a href="{{ route('services.index') }}"
                class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition
                {{ !request('category') && !request('search') ? 'bg-amber-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                All Services
            </a>

            @foreach($categories as $category)
                @php
                    // Find the service that matches this category name (case-insensitive)
                    $categoryService = $services->first(function($service) use ($category) {
                        return strtolower($service->name) === strtolower($category) ||
                               strpos(strtolower($service->name), strtolower($category)) !== false;
                    });
                @endphp
                
                @if($categoryService)
                    <!-- Link to electricians page for this service -->
                    <a href="{{ route('service.electricians', ['service' => $categoryService->slug]) }}"
                        class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition
                        {{ request('category') == $category ? 'bg-amber-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ $category }}
                    </a>
                @else
                    <!-- Fallback to category filter -->
                    <a href="{{ route('services.index', ['category' => $category]) }}"
                        class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition
                        {{ request('category') == $category ? 'bg-amber-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ $category }}
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Filters Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-3">
            <button class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
                Filter
            </button>
            
            <!-- Active Filters -->
            @if(request()->anyFilled(['search', 'category', 'min_price', 'max_price']))
                <div class="flex items-center gap-2">
                    @if(request('search'))
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-gray-100 rounded-full text-xs">
                            "{{ request('search') }}"
                            <a href="{{ route('services.index', array_merge(request()->except('search'), ['page' => null])) }}" class="text-gray-500 hover:text-gray-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </a>
                        </span>
                    @endif
                    
                    @if(request('category'))
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-gray-100 rounded-full text-xs">
                            {{ request('category') }}
                            <a href="{{ route('services.index', array_merge(request()->except('category'), ['page' => null])) }}" class="text-gray-500 hover:text-gray-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </a>
                        </span>
                    @endif
                    
                    @if(request('min_price') || request('max_price'))
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-gray-100 rounded-full text-xs">
                            ${{ request('min_price') ?? 0 }} - ${{ request('max_price') ?? '∞' }}
                            <a href="{{ route('services.index', array_merge(request()->except(['min_price', 'max_price']), ['page' => null])) }}" class="text-gray-500 hover:text-gray-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </a>
                        </span>
                    @endif
                </div>
            @endif
        </div>
        
        <p class="text-sm text-gray-500">
            {{ $services->total() }} services available
        </p>
    </div>

    <!-- Services Grid -->
    @if($services->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-4">
            @foreach($services as $service)
                <x-public.service-card :service="$service" />
            @endforeach
        </div>

        <!-- Pagination -->
        @if($services->hasPages())
            <div class="mt-10 flex justify-center">
                {{ $services->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        @endif

    @else
        <!-- Empty State -->
        <div class="text-center py-16 bg-white/80 rounded-xl">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">No services found</h3>
            <p class="text-gray-500 mb-4">Try adjusting your filters or search terms.</p>
            <a href="{{ route('services.index') }}" class="text-amber-600 font-medium hover:text-amber-700">
                Clear all filters
            </a>
        </div>
    @endif

    <!-- Featured Services Section -->
    @if(isset($featuredServices) && $featuredServices->isNotEmpty())
        <div class="mt-16 mb-4">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Featured services</h2>
                <a href="{{ route('services.index', ['featured' => true]) }}" class="text-sm text-amber-600 hover:text-amber-700 font-medium">
                    View all →
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredServices->take(3) as $index => $service)
                    <x-public.featured-service-card 
                        :service="$service" 
                        :badge="$index === 0 ? 'popular' : null" 
                    />
                @endforeach
            </div>
        </div>
    @endif

    <!-- Popular Services Quick Links -->
    <div class="mt-16">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Popular services</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @php
                $popularServiceNames = ['Emergency Electrical Repair', 'Wiring Installation', 'Lighting Installation', 'Panel Upgrade', 'Outlet & Switch Repair', 'Home Safety Inspection'];
                $popularServices = $services->whereIn('name', $popularServiceNames);
            @endphp
            
            @foreach($popularServices as $popularService)
                <a href="{{ route('service.electricians', ['service' => $popularService->slug]) }}" 
                   class="block p-4 bg-white/80 rounded-lg hover:bg-amber-50 transition border border-gray-200">
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">{{ $popularService->icon ?? '🔧' }}</span>
                        <div>
                            <h3 class="text-sm font-medium text-gray-800">{{ $popularService->name }}</h3>
                            <p class="text-xs text-amber-600">Find pros →</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="mt-16 bg-white/80 rounded-xl p-8 mb-4">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Frequently asked questions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-semibold text-gray-800 mb-2">How do I book a service?</h3>
                <p class="text-sm text-gray-600">Browse services, select one that fits your needs, and click "Find pros" to see available electricians and book a time.</p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800 mb-2">Are the prices final?</h3>
                <p class="text-sm text-gray-600">Prices shown are estimates. The electrician will confirm the final cost after assessing the job.</p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800 mb-2">What if I need to cancel?</h3>
                <p class="text-sm text-gray-600">Free cancellation up to 24 hours before the scheduled time. Later cancellations may incur a fee.</p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800 mb-2">How are electricians verified?</h3>
                <p class="text-sm text-gray-600">All electricians undergo license verification, background checks, and identity verification before joining.</p>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="mt-16 bg-amber-700 rounded-xl p-8 text-center">
        <h2 class="text-2xl font-bold text-white mb-3">Need help finding the right service?</h2>
        <p class="text-white/90 mb-6">Our support team is here to help you 24/7.</p>
        <div class="flex justify-center gap-4">
            <a href="{{ route('contact') }}" class="px-6 py-2.5 bg-white text-amber-600 font-medium rounded-lg hover:bg-gray-100 transition">
                Contact support
            </a>
            <a href="tel:+1234567890" class="px-6 py-2.5 border border-white text-white font-medium rounded-lg hover:bg-white/10 transition">
                Call now
            </a>
        </div>
    </div>
</div>

<!-- Hide scrollbar for category pills -->
<style>
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
@endsection