@props(['user'])

<div class="pt-2 pb-3 space-y-1">
    <x-mobile-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
        Home
    </x-mobile-nav-link>
    
    <x-mobile-nav-link href="{{ route('electricians.index') }}" :active="request()->routeIs('electricians.*')">
        Electricians
    </x-mobile-nav-link>
    
    <x-mobile-nav-link href="{{ route('services.index') }}" :active="request()->routeIs('services.*')">
        Services
    </x-mobile-nav-link>
    
    @auth
        @if(auth()->user()->isClient())
            <x-mobile-nav-link href="{{ route('bookings.create') }}" :active="request()->routeIs('bookings.create')">
                Book Now
            </x-mobile-nav-link>
        @endif
    @endauth
</div>

@auth
    <div class="pt-4 pb-3 border-t border-gray-200">
        <div class="flex items-center px-4">
            <div class="shrink-0">
                <div class="h-10 w-10 rounded-full bg-[#1e3a5f] flex items-center justify-center text-white uppercase font-semibold">
                    {{ substr($user->name, 0, 1) }}
                </div>
            </div>
            <div class="ml-3">
                <div class="text-base font-medium text-gray-800">{{ $user->name }}</div>
                <div class="text-sm font-medium text-gray-500">{{ $user->email }}</div>
            </div>
        </div>
        
        <div class="mt-3 space-y-1">
            <!-- Role-Specific Dashboard Links -->
            @if($user->isAdmin())
                <x-mobile-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        Admin Dashboard
                    </span>
                </x-mobile-nav-link>
            @elseif($user->isElectrician())
                <x-mobile-nav-link href="{{ route('electrician.dashboard') }}" :active="request()->routeIs('electrician.dashboard')">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Electrician Dashboard
                    </span>
                </x-mobile-nav-link>
            @elseif($user->isClient())
                <x-mobile-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        My Dashboard
                    </span>
                </x-mobile-nav-link>
            @endif

            <!-- Common Links -->
            <x-mobile-nav-link href="{{ route('profile.edit') }}" :active="request()->routeIs('profile.edit')">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profile Settings
                </span>
            </x-mobile-nav-link>

            @if($user->isElectrician())
                <x-mobile-nav-link href="{{ route('electrician.availability.index') }}" :active="request()->routeIs('electrician.availability.*')">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        My Availability
                    </span>
                </x-mobile-nav-link>

                <x-mobile-nav-link href="{{ route('electrician.bookings.index') }}" :active="request()->routeIs('electrician.bookings.*')">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        My Bookings
                    </span>
                </x-mobile-nav-link>
            @endif

            @if($user->isClient())
                <x-mobile-nav-link href="{{ route('bookings.index') }}" :active="request()->routeIs('bookings.*')">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        My Bookings
                    </span>
                </x-mobile-nav-link>
            @endif

            @if($user->isAdmin())
                <x-mobile-nav-link href="{{ route('admin.electricians.index') }}" :active="request()->routeIs('admin.electricians.*')">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Manage Electricians
                    </span>
                </x-mobile-nav-link>

                <x-mobile-nav-link href="{{ route('admin.services.index') }}" :active="request()->routeIs('admin.services.*')">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Manage Services
                    </span>
                </x-mobile-nav-link>

                <x-mobile-nav-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.users.*')">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Manage Users
                    </span>
                </x-mobile-nav-link>
            @endif

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="pt-2">
                @csrf
                <button type="submit" 
                        class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-red-50">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Sign out
                    </span>
                </button>
            </form>
        </div>
    </div>
@else
    <div class="pt-4 pb-3 border-t border-gray-200">
        <div class="space-y-1">
            <x-mobile-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                Login
            </x-mobile-nav-link>
            
            <x-mobile-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')">
                Sign up
            </x-mobile-nav-link>
        </div>
    </div>
@endauth