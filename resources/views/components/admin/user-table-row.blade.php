@props(['user'])

<tr class="hover:bg-gray-50 transition">
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center">
            <div class="shrink-0 h-10 w-10">
                <div class="h-10 w-10 rounded-full bg-[#1e3a5f] flex items-center justify-center text-white font-bold">
                    {{ substr($user->name, 0, 1) }}
                </div>
            </div>
            <div class="ml-4">
                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                <div class="text-sm text-gray-500">{{ $user->email }}</div>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
            @if($user->role === 'admin') bg-purple-100 text-purple-800
            @elseif($user->role === 'electrician') bg-green-100 text-green-800
            @else bg-blue-100 text-blue-800
            @endif">
            {{ ucfirst($user->role) }}
        </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-900">{{ $user->phone ?? 'N/A' }}</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        @if($user->hasVerifiedEmail())
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                Verified
            </span>
        @else
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">
                Unverified
            </span>
        @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-900">{{ $user->created_at->format('M d, Y') }}</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <div class="flex items-center justify-end space-x-3">
            <!-- View -->
            <a href="{{ route('admin.users.show', $user) }}" 
               class="text-[#3b82f6] hover:text-[#2563eb]" title="View">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </a>

            <!-- Edit -->
            <a href="{{ route('admin.users.edit', $user) }}" 
               class="text-indigo-600 hover:text-indigo-900" title="Edit">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </a>

            <!-- Verify/Unverify Email -->
            @if(!$user->hasVerifiedEmail())
                <form method="POST" action="{{ route('admin.users.verify-email', $user) }}" class="inline">
                    @csrf
                    <button type="submit" class="text-green-600 hover:text-green-900" title="Verify Email">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </button>
                </form>
            @endif

            <!-- Impersonate -->
            @if($user->id !== auth()->id())
                <form method="POST" action="{{ route('admin.users.impersonate', $user) }}" class="inline">
                    @csrf
                    <button type="submit" class="text-amber-600 hover:text-amber-900" title="Impersonate User">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </button>
                </form>
            @endif

            <!-- Delete -->
            @if($user->id !== auth()->id())
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                      onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');"
                      class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </form>
            @endif
        </div>
    </td>
</tr>