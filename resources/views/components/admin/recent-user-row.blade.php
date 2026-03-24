@props(['user'])

<div class="p-4 hover:bg-gray-50">
    <div class="flex items-center">
        <div class="shrink-0">
            <div class="h-10 w-10 rounded-full bg-[#1e3a5f] flex items-center justify-center text-white font-bold">
                {{ substr($user->name, 0, 1) }}
            </div>
        </div>
        <div class="ml-3 flex-1">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                <x-user-role-badge :role="$user->role" />
            </div>
            <p class="text-xs text-gray-500">{{ $user->email }}</p>
            <p class="text-xs text-gray-400">Joined {{ $user->created_at->format('M d, Y') }}</p>
        </div>
    </div>
</div>