@extends('layouts.app')

@section('title', 'ElectroBook - Find Trusted Electricians')

@section('content')


<!-- Hero section -->
<div class="relative bg-white overflow-hidden">
    <!-- Logo – hidden on mobile -->
    <div class="hidden sm:flex items-center justify-center mt-10">
        <div class="w-10 h-10 bg-[#009FD9] rounded-full flex items-center justify-center shadow-sm">
            <span class="text-white font-bold text-base">E</span>
        </div>
    </div>

    <!-- Image – ONLY on mobile (above heading) -->
    <div class="block sm:hidden relative overflow-hidden  pb-6">
        <div class="max-w-sm mx-auto px-4 py-6">
            <div class="relative flex justify-center">
                <div class="w-full max-w-sm mx-auto overflow-hidden">
                    <!-- Dome container -->
                    <div class="relative overflow-hidden rounded-t-full shadow-2xl"> 
                        <img 
                            src="{{ Storage::url('images/backgrounds/electrician.jpg') }}" 
                            alt="Professional electrician working"
                            class="w-full h-[200px] object-cover"
                            loading="eager"
                        >
                        <!-- Gradient overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-4 lg:py-8 text-center">
        <!-- Main heading  -->
        <h1 
            x-data="{ show: false }"
            x-init="setTimeout(() => show = true, 100)"
            x-show="show"
            x-transition:enter="transition-all duration-700 ease-out"
            x-transition:enter-start="opacity-0 scale-90 blur-sm"
            x-transition:enter-end="opacity-100 scale-100 blur-0"
            class="text-2xl md:text-4xl font-bold text-[#2F3033] mb-4"
        >
            Electrical Installations, made easy.
        </h1>
                <!-- Descriptive prompt -->
        <p class="text-sm md:text-lg text-[#2F3033] mb-6 max-w-2xl mx-auto">
            Describe your project or problem — be as detailed as you'd like!
        </p>

        <!-- Desktop search:-->
        <form action="{{ route('search') }}" method="GET" class="hidden sm:flex bg-white rounded shadow-lg border border-gray-200 gap-2 max-w-4xl mx-auto ">
            <div class="flex-1 relative">
                <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="q" placeholder="E.g., Fix a broken outlet, install ceiling fan, panel upgrade..." class="w-full pl-12 pr-4 py-4 focus:outline-none rounded text-black text-base">
            </div>
            <button class="bg-[#009FD9] text-white text-base px-5 py-3 rounded-r hover:bg-sky-700 transition-all duration-300 font-semibold shadow-md hover:shadow-lg">
                Find a pro
            </button>
        </form>

        <!-- Mobile search-->
        <div class="max-w-3xl mx-auto block sm:hidden">
            <form id="mobile-search-form" action="{{ route('search') }}" method="GET" class="bg-white rounded shadow-xl border border-gray-200">
                <div class="relative">
                    <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="q" placeholder="E.g., Fix a broken outlet, install ceiling fan, panel upgrade..." class="w-full pl-12 pr-4 py-4 focus:outline-none rounded text-gray-800 text-sm">
                </div>
            </form>
            <div class="mt-2 flex justify-center">
                <button type="submit" form="mobile-search-form" class="bg-sky-600 text-white text-sm px-5 py-3 rounded-md hover:bg-sky-700 transition-all duration-300 font-semibold shadow-md hover:shadow-lg w-full">
                    Find a pro
                </button>
            </div>
        </div>

        <!-- Popular searches -->
        <div class="flex flex-wrap gap-2 justify-center items-center mt-6">
            <span class="text-sm text-gray-600">Popular:</span>
            @forelse($popularServices as $service)
                <a href="{{ route('service.electricians', ['service' => $service->slug]) }}"
                class="px-3 py-2 bg-[#E8F1FD] shadow-sm rounded-full text-xs font-semibold text-[#2F3033] hover:text-[#009FD9] hover:bg-gray-200 transition">
                    {{ $service->name }}
                </a>
            @empty
                <span class="text-sm text-gray-400">No popular services yet</span>
            @endforelse
        </div>

        <!-- Trust badge (stars + reviews + people count) -->
        <div class="mt-8 flex flex-wrap items-center justify-center gap-2 text-gray-800 text-base ">
            <span class="text-[#2F3033]">Trusted by 4.5M+ people</span>
            <span class="font-semibold text-gray-800">
                4.9/5 <span class="text-green-500">★</span>
            </span>
            <span class="text-[#2F3033]">with over 300k reviews on the App Store</span>        
        </div>

        <!-- Dome-shaped image – ONLY on desktop -->
<div class="hidden md:block relative overflow-hidden pt-20 -mb-10">
    <div class="max-w-[655px] mx-auto px-4">
        <div class="relative flex justify-center">
            <div class="transform hover:scale-[1.02] transition duration-500 w-full">
                <div class="relative overflow-hidden rounded-t-full shadow-2xl">
                    <img 
                        src="{{ Storage::url('images/backgrounds/electrician.jpg') }}" 
                        alt="Professional electrician working"
                        class="w-full h-[327px] object-cover"
                        style="aspect-ratio: 655 / 327;"
                        loading="eager"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent"></div>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
</div>

<!-- TRUST BAR -->
<div class="bg-gray-100 border-y border-gray-100">
    <div class="max-w-7xl mx-auto px-6 py-10 grid md:grid-cols-3 gap-8 text-center">
        <div class="flex items-center justify-center space-x-3">
            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="text-left">
                <p class="font-semibold text-[#2F3033]">Verified Electricians</p>
                <p class="text-sm text-[#2F3033]">Background checked professionals</p>
            </div>
        </div>
        <div class="flex items-center justify-center space-x-3">
            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-[#009FD9]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="text-left">
                <p class="font-semibold text-[#2F3033]">Instant Booking</p>
                <p class="text-sm text-[#2F3033]">Book services in minutes</p>
            </div>
        </div>
        <div class="flex items-center justify-center space-x-3">
            <div class="w-10 h-10 bg-sky-100 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-[#009FD9]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            </div>
            <div class="text-left">
                <p class="font-semibold text-[#2F3033]">Trusted by Customers</p>
                <p class="text-sm text-[#2F3033]">Thousands of completed jobs</p>
            </div>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="relative p-20 mt-10 text-white overflow-hidden">

    <!-- Background Image -->
    <div class="absolute inset-0">
        <img 
            src="{{Storage::url('images/backgrounds/power-outage.jpg')}}"
            class="w-full h-full object-cover"
            alt="Electrical work background"
        >
    </div>

    <!-- Content -->
    <div class="relative max-w-7xl mx-auto my-12 py-5 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">

            <div>
                <p class="text-3xl font-bold mb-2">500+</p>
                <p class="text-[#2F3033]">Verified electricians</p>
            </div>

            <div>
                <p class="text-3xl font-bold mb-2">10k+</p>
                <p class="text-[#2F3033]">Jobs completed</p>
            </div>

            <div>
                <p class="text-3xl font-bold mb-2">4.8/5</p>
                <p class="text-[#2F3033]">Average rating</p>
            </div>

            <div>
                <p class="text-3xl font-bold mb-2">24/7</p>
                <p class="text-[#2F3033]">Emergency service</p>
            </div>

        </div>
    </div>
</div>

<!-- How It Works -->
<div class="py-10 md:py-20 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 md:mb-12">
            <span class="text-[#009FD9] font-semibold text-base uppercase tracking-wider">Simple Process</span>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4 mt-2">How it works</h2>
            <p class="text-base md:text-lg text-gray-600 max-w-2xl mx-auto">Three simple steps to get your electrical work done</p>
        </div>
        
        <div class="grid grid-cols-3 md:grid-cols-3 gap-6 md:gap-6">
            <!-- Step 1 -->
            <div class="text-center group">
                <div class="relative w-full h-64 md:h-80 mx-auto mb-4 md:mb-6 rounded-2xl overflow-hidden shadow-xl group-hover:shadow-2xl transition-all duration-300 group-hover:scale-105">
                    <img src="{{ Storage::url('images/how-it-works/compare.jpg') }}" 
                         alt="Describe project" 
                         class="w-full h-full object-cover"
                         loading="lazy">
                </div>
                <div class="w-12 h-12 md:w-14 md:h-14 bg-[#009FD9] text-white rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4 shadow-lg text-lg md:text-xl font-bold">1</div>
                <h3 class="text-xl md:text-2xl font-semibold mb-2 text-gray-800">Tell us what you need</h3>
                <p class="text-base md:text-lg text-gray-600 max-w-xs mx-auto">Describe your electrical project and we'll match you with qualified pros.</p>
            </div>
            
            <!-- Step 2 -->
            <div class="text-center group">
                <div class="relative w-full h-64 md:h-80 mx-auto mb-4 md:mb-6 rounded-2xl overflow-hidden shadow-xl group-hover:shadow-2xl transition-all duration-300 group-hover:scale-105">
                    <img src="{{ Storage::url('images/how-it-works/compare2.jpg') }}" 
                         alt="Compare professionals" 
                         class="w-full h-full object-cover"
                         loading="lazy">
                </div>
                <div class="w-12 h-12 md:w-14 md:h-14 bg-[#009FD9] text-white rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4 shadow-lg text-lg md:text-xl font-bold">2</div>
                <h3 class="text-xl md:text-2xl font-semibold mb-2 text-gray-800">Compare & choose</h3>
                <p class="text-base md:text-lg text-gray-600 max-w-xs mx-auto">Review profiles, ratings, and prices to find the perfect electrician.</p>
            </div>
            
            <!-- Step 3 -->
            <div class="text-center group">
                <div class="relative w-full h-64 md:h-80 mx-auto mb-4 md:mb-6 rounded-2xl overflow-hidden shadow-xl group-hover:shadow-2xl transition-all duration-300 group-hover:scale-105">
                    <img src="{{ Storage::url('images/how-it-works/job-done.jpg') }}"  
                         alt="Job completed" 
                         class="w-full h-full object-cover"
                         loading="lazy">
                </div>
                <div class="w-12 h-12 md:w-14 md:h-14 bg-[#009FD9] text-white rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4 shadow-lg text-lg md:text-xl font-bold">3</div>
                <h3 class="text-xl md:text-2xl font-semibold mb-2 text-gray-800">Book & get it done</h3>
                <p class="text-base md:text-lg text-gray-600 max-w-xs mx-auto">Schedule a time that works for you and get your problem solved.</p>
            </div>
        </div>
    </div>
</div>

<!-- Popular Services -->
<div class="py-12 md:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 md:mb-12">
            <div>
                <span class="text-[#009FD9] font-semibold text-base uppercase tracking-wider">Services</span>
                <h2 class="text-2xl md:text-3xl font-bold text-[#2F3033] mt-2">Popular Electrical Services</h2>
            </div>
            <a href="{{ route('services.index') }}" class="text-[#009FD9] hover:text-sky-600 font-medium inline-flex items-center group text-sm md:text-base">
                View all services
                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <!-- Swiper Slider Container -->
        <div class="relative px-8 md:px-12">
            <div class="swiper-container overflow-hidden" id="servicesSlider">
                <div class="swiper-wrapper">
                    @foreach($popularServices as $popularService)
                        <div class="swiper-slide">
                            <a href="{{ route('service.electricians', ['service' => $popularService->slug]) }}" 
                               class="relative group overflow-hidden rounded-2xl shadow-md hover:shadow-2xl transition-all duration-500 block">
                                <img 
                                    src="{{ Storage::url($popularService->image) }}"
                                    alt="{{ $popularService->name }}"
                                    class="w-full h-50 sm:h-48 md:h-80 object-cover group-hover:scale-110 transition-transform duration-500"
                                    loading="lazy"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-3 md:p-5">
                                    <span class="text-white font-semibold text-sm md:text-base block">{{ $popularService->name }}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Custom Navigation Buttons with Tailwind -->
            <button class="swiper-button-prev-custom absolute left-0 top-1/2 -translate-y-1/2 bg-[#009FD9] hover:bg-sky-700 text-white w-10 h-10 rounded-full shadow-lg transition-all duration-300 flex items-center justify-center z-10 focus:outline-none focus:ring-2 focus:ring-[#009FD9] focus:ring-offset-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button class="swiper-button-next-custom absolute right-0 top-1/2 -translate-y-1/2 bg-[#009FD9] hover:bg-sky-700 text-white w-10 h-10 rounded-full shadow-lg transition-all duration-300 flex items-center justify-center z-10 focus:outline-none focus:ring-2 focus:ring-[#009FD9] focus:ring-offset-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
        
        <!-- Pagination Dots -->
        <div class="swiper-pagination mt-8"></div>
    </div>
</div>

<!-- Swiper CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const swiper = new Swiper('#servicesSlider', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            navigation: {
                nextEl: '.swiper-button-next-custom',
                prevEl: '.swiper-button-prev-custom',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 25,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
            },
            effect: 'slide',
            speed: 800,
            grabCursor: true,
            touchRatio: 1,
        });
    });
</script>

<!-- Custom Tailwind-compatible styles -->
<style>
    /* Override Swiper default styles with Tailwind-friendly classes */
    .swiper-pagination-bullet {
        @apply bg-[#009FD9] opacity-50 transition-all duration-300;
    }
    
    .swiper-pagination-bullet-active {
        @apply bg-[#009FD9] opacity-100 w-8 rounded-full;
    }
    
    .swiper-button-prev-custom,
    .swiper-button-next-custom {
        backdrop-filter: blur(4px);
    }
    
    .swiper-button-prev-custom:hover,
    .swiper-button-next-custom:hover {
        transform: translateY(-50%) scale(1.1);
    }
    
    /* Hide navigation buttons on very small screens */
    @media (max-width: 640px) {
        .swiper-button-prev-custom,
        .swiper-button-next-custom {
            @apply w-8 h-8;
        }
        
        .swiper-button-prev-custom svg,
        .swiper-button-next-custom svg {
            @apply w-4 h-4;
        }
    }
    
    /* Add smooth gradient fade on edges for better UX */
    .swiper-container {
        mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
        -webkit-mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
    }
    
    /* Remove mask on touch devices for better interaction */
    @media (hover: none) {
        .swiper-container {
            mask-image: none;
            -webkit-mask-image: none;
        }
    }
</style>
<!-- Featured Electricians -->
<div class="py-12 md:py-20 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 md:mb-12">
            <span class="text-[#009FD9] font-semibold text-sm uppercase tracking-wider">Top Rated</span>
            <h2 class="text-2xl md:text-4xl font-bold text-[#2F3033] mt-2 mb-4">Featured Electricians</h2>
            <p class="text-[#2F3033] max-w-2xl mx-auto">Choose from our most trusted and highly-rated professionals</p>
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
        
        <div class="grid grid-cols-4 md:grid-cols-4 lg:grid-cols-4 gap-6 md:gap-6">
            @forelse($featuredElectricians as $index => $electrician)
                <a href="{{ route('electricians.show', $electrician) }}" 
                   class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group flex flex-col h-full">
                    <div class="relative pt-6 px-6">
                        <div class="flex justify-center">
                            <div class="w-28 h-28 md:w-32 md:h-32 rounded-full border border-white shadow-md overflow-hidden bg-gray-100">
                                <img src="{{ $electrician->profile_photo }}" 
                                     alt="{{ $electrician->business_name }}" 
                                     class="w-full h-full object-cover"
                                     loading="lazy">
                            </div>
                        </div>
                        <!-- Optional badge for top rated -->
                        @if($index == 0)
                            <div class="absolute top-0 right-4 bg-amber-500 text-white text-xs font-semibold px-2 py-1 rounded-full shadow-sm">
                                ⭐ Top Rated
                            </div>
                        @endif
                    </div>

                    <!-- Card content -->
                    <div class="p-5 text-center flex-grow flex flex-col">
                        <h3 class="font-bold text-[#2F3033] text-lg md:text-xl mb-1">{{ $electrician->business_name }}</h3>
                        <p class="text-sm text-gray-500 mb-2">{{ $electrician->years_experience }} years experience</p>
                        
                        <!-- Rating -->
                        <div class="flex items-center justify-center mb-3">
                            <div class="flex text-[#009FD9]">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($electrician->rating))
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 fill-current text-gray-300" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500 ml-2">{{ $electrician->reviews_count }}</span>
                        </div>
                        
                        <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ $electrician->bio ?? 'Professional electrician providing quality electrical services.' }}</p>
                        
                        <!-- Price -->
                        <div class="mt-auto">
                            <div class="text-[#009FD9] font-semibold text-lg">
                                R{{ number_format($electrician->hourly_rate ?? 200, 0) }}<span class="text-sm font-normal text-gray-500">/hr</span>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-4 text-center text-gray-500 py-8">
                    No featured electricians available at the moment.
                </div>
            @endforelse
        </div>
        
        <div class="text-center mt-8 md:mt-10">
            <a href="{{ route('electricians.index') }}" class="inline-flex items-center px-6 py-3 bg-[#009FD9] text-white rounded-xl hover:bg-sky-700 transition-all duration-300 font-medium shadow-md hover:shadow-lg text-sm md:text-base">
                Find more electricians
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</div>
<!-- Why Choose Us with Images -->
<div class="py-12 md:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 md:mb-12">
            <span class="text-[#009FD9] font-semibold text-sm uppercase tracking-wider">Why Choose Us</span>
            <h2 class="text-2xl md:text-4xl font-bold text-[#2F3033] mt-2 mb-4">Why customers love ElectroBook</h2>
            <p class="text-base md:text-lg text-gray-600">Thousands of satisfied customers trust us with their electrical needs</p>
        </div>
        
        <div class="grid grid-cols-3 md:grid-cols-3 gap-6 md:gap-4">
            <div class="text-center group">
                <div class="relative w-50 h-50 md:w-250 md:h-150 mx-auto mb-4 rounded-xl overflow-hidden shadow-lg group-hover:shadow-2xl transition-all duration-300 group-hover:scale-105">
                    <img src="{{Storage::url('images/why-choose-us/verified-professionals.jpg') }}" 
                         alt="Verified professionals" 
                         class="w-full h-full object-cover"
                         loading="lazy">
                </div>
                <h3 class="font-semibold text-lg md:text-xl mb-2 text-[#2F3033]">Verified professionals</h3>
                <p class="text-sm md:text-base text-gray-600">Every electrician is licensed, insured, and background-checked.</p>
            </div>
            
            <div class="text-center group">
                <div class="relative w-50 h-50 md:w-250 md:h-150 mx-auto mb-4 rounded-xl overflow-hidden shadow-lg group-hover:shadow-2xl transition-all duration-300 group-hover:scale-105">
                    <img src="{{ Storage::url('images/why-choose-us/instant-booking2.jpg') }}" 
                         alt="Instant booking" 
                         class="w-full h-full object-cover"
                         loading="lazy">
                </div>
                <h3 class="font-semibold text-lg md:text-xl mb-2 text-gray-800">Instant booking</h3>
                <p class="text-sm md:text-base text-gray-600">Book appointments instantly with real-time availability.</p>
            </div>
            
            <div class="text-center group">
                <div class="relative w-50 h-50 md:w-250 md:h-150 mx-auto mb-4 rounded-xl overflow-hidden shadow-lg group-hover:shadow-2xl transition-all duration-300 group-hover:scale-105">
                    <img src="{{ Storage::url('images/why-choose-us/Satisfaction2.jpeg') }}" 
                         alt="Satisfaction guaranteed" 
                         class="w-full h-full object-cover"
                         loading="lazy">
                </div>
                <h3 class="font-semibold text-lg md:text-xl mb-2 text-gray-800">Satisfaction guaranteed</h3>
                <p class="text-sm md:text-base text-gray-600">Not happy? We'll work to make it right.</p>
            </div>
        </div>
    </div>
</div>

<!-- Customer Testimonials -->
<div class="py-12 md:py-20 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 md:mb-12">
            <span class="text-[#009FD9] font-semibold text-sm uppercase tracking-wider">Testimonials</span>
            <h2 class="text-2xl md:text-4xl font-bold text-[#2F3033] mt-2 mb-4">What our customers say</h2>
            <p class="text-base md:text-lg text-gray-500">Real stories from real customers</p>
        </div>
        
        @php
            $testimonials = App\Models\Review::with(['client', 'electrician'])
                ->whereNotNull('comment')
                ->where('comment', '!=', '')
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();
            
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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                @foreach($testimonials as $review)
                    <div class="bg-white rounded-2xl shadow-lg p-5 md:p-6 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 md:w-14 md:h-14 rounded-full overflow-hidden bg-gray-200 shadow-md mr-4 flex-shrink-0">
                                <img src="{{ $review->client->avatar_url ?? 'https://ui-avatars.com/api/?background=6b7280&color=fff&bold=true&size=128&name=?' }}" 
                                     alt="{{ $review->client->name ?? 'Customer' }}" 
                                     class="w-full h-full object-cover"
                                     loading="lazy">
                            </div>
                            <div>
                                <h4 class="font-semibold text-[#2F3033] text-sm md:text-base">{{ $review->client->name ?? 'Customer' }}</h4>
                                <div class="flex items-center">
                                    <div class="flex text-[#009FD9] text-xs md:text-sm">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 fill-current text-gray-300" viewBox="0 0 20 20">
                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-xs text-gray-500 ml-2">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600 italic text-sm md:text-base line-clamp-4">"{{ $review->comment }}"</p>
                        @if($review->electrician)
                            <div class="mt-4 pt-3 border-t border-gray-100">
                                <p class="text-xs text-gray-400">
                                    Service by: 
                                    <span class="text-[#009FD9] font-medium">{{ $review->electrician->business_name }}</span>
                                </p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="bg-white rounded-2xl p-8 max-w-md mx-auto shadow-lg">
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
<div id="faq" class="py-12 md:py-20 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 md:mb-12">
            <span class="text-[#009FD9] font-semibold text-sm uppercase tracking-wider">FAQ</span>
            <h2 class="text-2xl md:text-3xl font-bold text-[#2F3033] mt-2 mb-4">Frequently asked questions</h2>
            <p class="text-base md:text-lg text-gray-600">Got questions? We've got answers</p>
        </div>
        
        <div class="space-y-4">
            <div class="bg-white rounded-xl border border-gray-200 hover:shadow-md transition-all duration-300" x-data="{ open: false }">
                <button @click="open = !open" class="flex justify-between items-center w-full px-4 md:px-6 py-4 md:py-5">
                    <span class="font-medium text-[#2F3033] text-sm md:text-lg">How do I book an electrician?</span>
                    <svg class="w-5 h-5 text-gray-500 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="px-4 md:px-6 pb-4 md:pb-5 text-gray-600 border-t border-gray-100 text-sm md:text-base">
                    <p>Simply search for the service you need, browse electricians in your area, check their reviews and rates, and book a time that works for you. You'll receive an instant confirmation via email and SMS.</p>
                </div>
            </div>
            
            <div class="bg-white rounded-xl border border-gray-200 hover:shadow-md transition-all duration-300" x-data="{ open: false }">
                <button @click="open = !open" class="flex justify-between items-center w-full px-4 md:px-6 py-4 md:py-5">
                    <span class="font-medium text-[#2F3033] text-sm md:text-lg">Are electricians verified?</span>
                    <svg class="w-5 h-5 text-gray-500 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="px-4 md:px-6 pb-4 md:pb-5 text-gray-600 border-t border-gray-100 text-sm md:text-base">
                    <p>Yes, all electricians on our platform go through a thorough verification process including license checks, background screening, identity verification, and insurance validation before they can accept bookings.</p>
                </div>
            </div>
            
            <div class="bg-white rounded-xl border border-gray-200 hover:shadow-md transition-all duration-300" x-data="{ open: false }">
                <button @click="open = !open" class="flex justify-between items-center w-full px-4 md:px-6 py-4 md:py-5">
                    <span class="font-medium text-gray-800 text-sm md:text-lg">What if I need emergency service?</span>
                    <svg class="w-5 h-5 text-gray-500 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="px-4 md:px-6 pb-4 md:pb-5 text-gray-600 border-t border-gray-100 text-sm md:text-base">
                    <p>Many of our electricians offer 24/7 emergency services. Look for the "Available now" badge or filter by emergency services to find help immediately. Emergency response typically within 60 minutes.</p>
                </div>
            </div>
            
            <div class="bg-white rounded-xl border border-gray-200 hover:shadow-md transition-all duration-300" x-data="{ open: false }">
                <button @click="open = !open" class="flex justify-between items-center w-full px-4 md:px-6 py-4 md:py-5">
                    <span class="font-medium text-[#2F3033] text-sm md:text-lg">How does pricing work?</span>
                    <svg class="w-5 h-5 text-gray-500 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="px-4 md:px-6 pb-4 md:pb-5 text-gray-600 border-t border-gray-100 text-sm md:text-base">
                    <p>Electricians set their own hourly rates. You'll see the price upfront before booking. There are no hidden fees or surprises. Payment is processed securely through our platform after the job is completed.</p>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-8">
            <a href="#" class="text-[#009FD9] hover:text-sky-600 font-medium inline-flex items-center group text-sm md:text-base">
                View all FAQs
                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="relative bg-gray-100 overflow-hidden">
    
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16 text-center">
        <h2 class="text-2xl md:text-4xl font-bold text-[#2F3033] mb-4">Ready to get started?</h2>
        <p class="text-base md:text-xl text-gray-500 mb-8">Join thousands of satisfied customers who found their trusted electrician through ElectroBook.</p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('services.index') }}" class="px-6 md:px-8 py-3 bg-white text-[#009FD9] font-medium rounded-xl hover:bg-gray-100 transition-all duration-300 shadow-lg hover:shadow-xl text-sm md:text-base">
                Find an electrician
            </a>
            @guest
                <a href="{{ route('register') }}" class="px-6 md:px-8 py-3 border-2 border-white bg-[#009FD9] font-medium rounded-xl hover:bg-white/10 transition-all duration-300 text-sm md:text-base">
                    Sign up as electrician
                </a>
            @endguest
        </div>
        <p class="text-gray-500 text-xs md:text-sm mt-6">No credit card required • Free to browse</p>
    </div>
</div>



@endsection