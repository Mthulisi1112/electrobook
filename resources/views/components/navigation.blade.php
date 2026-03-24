@props(['user' => null])

<nav class="bg-white border-b border-gray-200 fixed w-full z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-[#1e3a5f]">
                        Electro<span class="text-[#3b82f6]">Book</span>
                    </a>
                </div>
                
                <!-- Desktop Navigation Links -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                        Home
                    </x-nav-link>
                    
                    <x-nav-link href="{{ route('electricians.index') }}" :active="request()->routeIs('electricians.*')">
                        Electricians
                    </x-nav-link>
                    
                    <x-nav-link href="{{ route('services.index') }}" :active="request()->routeIs('services.*')">
                        Services
                    </x-nav-link>
                    
                    @auth
                        @if(auth()->user()->isClient())
                            <x-nav-link href="{{ route('bookings.create') }}" :active="request()->routeIs('bookings.create')">
                                Book Now
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>
            
            <!-- Desktop User Menu -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                @auth
                    <x-user-dropdown :user="auth()->user()" />
                @else
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" 
                           class="text-gray-500 hover:text-gray-700">Login</a>
                        <a href="{{ route('register') }}"
                           class="bg-[#3b82f6] text-white px-4 py-2 rounded-md hover:bg-[#2563eb] transition">
                            Sign up
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button @click="mobileOpen = !mobileOpen" type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-[#3b82f6]"
                        aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="sm:hidden" id="mobile-menu" x-show="mobileOpen" @click.away="mobileOpen = false" style="display: none;">
        <x-mobile-menu :user="auth()->user()" />
    </div>
</nav>