<div class="py-1">
    <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
        Admin
    </div>
    <a href="{{ route('admin.dashboard') }}" 
       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-50' : '' }}">
        📊 Dashboard
    </a>
    <a href="{{ route('admin.electricians.index') }}"
       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.electricians.*') ? 'bg-gray-50' : '' }}">
        👷 Electricians
    </a>
    <a href="{{ route('admin.services.index') }}"
       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.services.*') ? 'bg-gray-50' : '' }}">
        🔧 Services
    </a>
    <a href="{{ route('admin.users.index') }}"
       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.users.*') ? 'bg-gray-50' : '' }}">
        👥 Users
    </a>
    <a href="{{ route('admin.reports') }}"
       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('admin.reports') ? 'bg-gray-50' : '' }}">
        📈 Reports
    </a>
</div>
<div class="border-t border-gray-100"></div>