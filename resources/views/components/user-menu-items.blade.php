@props(['user'])

<div class="py-1">
    <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
        My Account
    </div>
    <a href="{{ route('dashboard') }}" 
       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-gray-50' : '' }}">
        📋 Dashboard
    </a>
    <a href="{{ route('profile.edit') }}"
       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('profile.edit') ? 'bg-gray-50' : '' }}">
        ⚙️ Profile Settings
    </a>
    @if($user->isElectrician())
        <a href="{{ route('availability.index') }}"
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('availability.*') ? 'bg-gray-50' : '' }}">
            📅 My Availability
        </a>
    @endif
</div>