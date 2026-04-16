<style>
.nav-custom {
    -webkit-text-size-adjust: 100%;
    font-family: Rise, Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    color: #676d73;
    font-size: 14px !important;
}
.nav-custom svg {
    fill: #009fd9;
}
.nav-custom a,
.nav-custom button {
    cursor: pointer;
}
/* Override Tailwind text size classes to maintain consistent 14px base */
.nav-custom .text-xs,
.nav-custom .text-sm,
.nav-custom .text-base {
    font-size: inherit !important;
}
</style>

<nav x-data="{ 
    open: false, 
    profile: false,
    servicesDropdown: false,
    search: false,
    activeLink: '{{ request()->routeIs('home') ? 'home' : (request()->routeIs('services.index') ? 'services' : '') }}'
}" 
class="nav-custom bg-white border-b  sticky top-0 z-50 shadow-sm">

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

<div class="flex justify-between items-center h-14 md:h-16">

<!-- Logo only -->
<div class="flex items-center -ml-4">
    <a href="{{ route('home') }}" class="flex items-center">
         <div class="w-10 h-10 bg-[#009FD9] rounded-full flex items-center justify-center shadow-sm">
            <span class="text-white font-bold text-base">E</span>
        </div>
    </a>
</div>

<!--links -->
<div class="hidden md:flex items-center space-x-2">
    <!-- Explore Services Dropdown -->
    <div class="relative" x-data="{ open: false }">
        <button 
            @click="open = !open"
            @click.away="open = false"
            :class="{ 'text-[#1f75fe]': activeLink === 'services' }"
            class="flex items-center space-x-1 px-4 py-2 text-sm text-gray-600 hover:text-[#1f75fe] transition"
        >
            <span class="text-[#676D73] text-sm">Explore Services</span>
            <svg class="w-4 h-4" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        
        <!-- Dropdown Menu -->
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-1"
            class="absolute right-0 mt-3 w-72 bg-white rounded-lg shadow-lg border border-gray-100 py-2 max-h-96 overflow-y-auto"
            style="display: none;"
        >
            <a href="{{ route('services.index') }}" class="block px-4 py-2.5 font-bold text-black text-sm hover:bg-gray-50 hover:text-[#1f75fe]">
                All Services
            </a> 
            <div class="border-t border-gray-100 my-1"></div>
            
            <!-- Main Services -->
            <div class="px-4 py-1.5 text-xs font-semibold text-black uppercase tracking-wider">Electrical Services</div>
            
            <a href="{{ route('service.electricians', ['service' => 'emergency-electrical-repair']) }}" class="flex items-center px-4 py-2 text-sm text-gray-800 hover:bg-gray-50 hover:text-[#1f75fe]">
                <span class="w-5 h-5 mr-3 text-gray-800">⚡</span>
                Emergency Electrical Repair
            </a>
            <a href="{{ route('service.electricians', ['service' => 'wiring-installation']) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                <span class="w-5 h-5 mr-3 text-gray-400">🔌</span>
                Wiring Installation
            </a>
            <a href="{{ route('service.electricians', ['service' => 'lighting-installation']) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                <span class="w-5 h-5 mr-3 text-gray-400">💡</span>
                Lighting Installation
            </a>
            <a href="{{ route('service.electricians', ['service' => 'panel-upgrade']) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                <span class="w-5 h-5 mr-3 text-gray-400">⬆️</span>
                Panel Upgrade
            </a>
            <a href="{{ route('service.electricians', ['service' => 'outlet-switch-repair']) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                <span class="w-5 h-5 mr-3 text-gray-400">🔧</span>
                Outlet & Switch Repair
            </a>
            <a href="{{ route('service.electricians', ['service' => 'home-safety-inspection']) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                <span class="w-5 h-5 mr-3 text-gray-400">🔍</span>
                Home Safety Inspection
            </a>
            
            <div class="border-t border-gray-100 my-1"></div>
            <div class="px-4 py-1.5 text-xs font-semibold text-black uppercase tracking-wider">More Services</div>
            
            <a href="{{ route('service.electricians', ['service' => 'test-service-1']) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                <span class="w-5 h-5 mr-3 text-gray-400">🛠️</span>
                Test Service 1
            </a>
            <a href="{{ route('service.electricians', ['service' => 'test-service-2']) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                <span class="w-5 h-5 mr-3 text-gray-400">🛠️</span>
                Test Service 2
            </a>
            <a href="{{ route('service.electricians', ['service' => 'security-service-1-1773823292-1']) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                <span class="w-5 h-5 mr-3 text-gray-400">🔒</span>
                Security Service 1
            </a>
            <a href="{{ route('service.electricians', ['service' => 'security-service-4-1773823292-4']) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                <span class="w-5 h-5 mr-3 text-gray-400">🔒</span>
                Security Service 4
            </a>
            <a href="{{ route('service.electricians', ['service' => 'emergency-service-2-1773823292-2']) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                <span class="w-5 h-5 mr-3 text-gray-400">🚨</span>
                Emergency Service 2
            </a>
            <a href="{{ route('service.electricians', ['service' => 'electrical-service-3-1773823292-3']) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                <span class="w-5 h-5 mr-3 text-gray-400">⚡</span>
                Electrical Service 3
            </a>
        </div>
    </div>

    <!-- Join as a pro Link -->
    <a href="{{ route('electricians.index') }}" class="px-4 py-1 text-xs font-medium text-[#676D73] hover:text-[#1f75fe] transition">
        Join as a pro
    </a>

    <!-- Divider -->
    <div class="h-5 w-px bg-gray-200 mx-2"></div>

    <!-- Sign up Button-->
    <a href="{{ route('register') }}" class="ml-1 px-6 py-3 bg-[#009FD9] text-white text-xs font-semibold rounded hover:bg-sky-600 transition shadow-sm">
        Sign up
    </a>

    <!-- Log in Link -->
    <a href="{{ route('login') }}" class="pl-6 py-1 text-xs font-medium text-[#676D73] hover:text-[#1f75fe] transition">
        Log in
    </a>

    <!-- Admin Dropdown (only for admins) -->
    @auth
        @if(auth()->user()->isAdmin())
        <div class="relative ml-1" x-data="{ open: false }">
            <button 
                @click="open = !open"
                @click.away="open = false"
                class="flex items-center space-x-1 px-3 py-2 text-sm font-medium text-gray-600 hover:text-[#1f75fe] transition"
            >
                <span>Admin</span>
                <svg class="w-4 h-4" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            
            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-1"
                class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1"
                style="display: none;"
            >
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                    Dashboard
                </a>
                <a href="{{ route('admin.electricians.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                    Electricians
                </a>
                <a href="{{ route('admin.services.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                    Services
                </a>
                <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                    Users
                </a>
                <a href="{{ route('admin.reports') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                    Reports
                </a>
            </div>
        </div>
        @endif
    @endauth
</div>

<!-- Mobile menu button and search for mobile -->
<div class="flex items-center space-x-2 md:hidden">
    <!-- Search Button -->
    <button @click="search = !search" class="p-2 text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
    </button>
    
    <button @click="open = !open" class="p-2 text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100 transition">
        <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" style="display: none;">
            <path stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>



<!-- Profile for authenticated users (desktop) -->
@auth
<div class="hidden md:flex items-center ml-2">
    <div class="relative">
        <button 
            @click="profile = !profile"
            class="flex items-center space-x-1 p-1.5 hover:bg-gray-100 rounded-full transition"
        >
            @php
                $avatar = auth()->user()->profile_photo_path;
            @endphp
            
            @if($avatar && Storage::disk('public')->exists($avatar))
                <img src="{{ Storage::url($avatar) }}" 
                     alt="{{ auth()->user()->name }}"
                     class="w-8 h-8 rounded-full object-cover">
            @else
                <div class="w-8 h-8 rounded-full bg-[#1f75fe] text-white flex items-center justify-center text-sm font-medium">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            @endif
        </button>

        <div
            x-show="profile"
            @click.away="profile = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-1"
            class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-1"
            style="display: none;"
        >
            @if(auth()->user()->isElectrician())
                <a href="{{ route('electrician.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                    Dashboard
                </a>
                <a href="{{ route('electrician.earnings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                    Earnings
                </a>
                <a href="{{ route('electrician.availability.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                    Availability
                </a>
            @elseif(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                    Admin Dashboard
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                    My Bookings
                </a>
            @endif
            
            <div class="border-t border-gray-100 my-1"></div>
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                Profile Settings
            </a>
            <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100 mt-1 pt-1">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:text-red-700 hover:bg-red-50">
                    Sign out
                </button>
            </form>
        </div>
    </div>
</div>
@endauth

</div>

<!-- Search Bar -->
<div x-show="search" x-collapse class="border-t border-gray-100 py-3 px-4" style="display: none;">
    <div class="relative max-w-2xl mx-auto">
        <form action="{{ route('services.index') }}" method="GET">
            <input type="text" 
                   name="search"
                   placeholder="Search for services or electricians..." 
                   class="w-full px-4 py-2.5 pl-10 text-sm border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-[#1f75fe] focus:border-transparent bg-gray-50">
            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </form>
    </div>
</div>

<!-- Mobile Sidebar -->
<div
    x-show="open"
    class="fixed inset-0 z-50 md:hidden"
    style="display: none;"
>
    <div class="fixed inset-0 bg-black/20" @click="open = false"></div>
    <div class="fixed top-0 right-0 bottom-0 w-80 bg-white shadow-xl overflow-y-auto">
        <div class="p-4 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <span class="text-lg font-semibold text-gray-800">ElectroBook</span>
                <button @click="open = false" class="p-2 hover:bg-gray-100 rounded-full">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        
        <div class="py-2">
            <a href="{{ route('services.index') }}" class="block px-4 py-3 text-base text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                All Services
            </a>
            <a href="{{ route('electricians.index') }}" class="block px-4 py-3 text-base text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                Join as a pro
            </a>
            <div class="border-t border-gray-100 my-2"></div>
            
            @guest
                <a href="{{ route('login') }}" class="block px-4 py-3 text-base text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                    Log in
                </a>
                <a href="{{ route('register') }}" class="block px-4 py-3 text-base font-semibold text-[#1f75fe] hover:bg-gray-50">
                    Sign up
                </a>
            @else
                @if(auth()->user()->isElectrician())
                    <a href="{{ route('electrician.dashboard') }}" class="block px-4 py-3 text-base text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                        Dashboard
                    </a>
                    <a href="{{ route('electrician.earnings') }}" class="block px-4 py-3 text-base text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                        Earnings
                    </a>
                @elseif(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 text-base text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                        Admin Dashboard
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="block px-4 py-3 text-base text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                        My Bookings
                    </a>
                @endif
                <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-base text-gray-700 hover:bg-gray-50 hover:text-[#1f75fe]">
                    Profile Settings
                </a>
                <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100 mt-2 pt-2">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 text-base text-red-600 hover:text-red-700 hover:bg-red-50">
                        Sign out
                    </button>
                </form>
            @endguest
        </div>
    </div>
</div>

</nav>