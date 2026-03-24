@props(['electrician'])

<tr class="hover:bg-gray-50 transition">
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center">
            <div class="shrink-0 h-10 w-10">
                <div class="h-10 w-10 rounded-full bg-[#1e3a5f] flex items-center justify-center text-white font-bold">
                    {{ substr($electrician->business_name, 0, 1) }}
                </div>
            </div>
            <div class="ml-4">
                <div class="text-sm font-medium text-gray-900">{{ $electrician->business_name }}</div>
                <div class="text-sm text-gray-500">{{ $electrician->user->name }}</div>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-900">{{ $electrician->user->email }}</div>
        <div class="text-sm text-gray-500">{{ $electrician->phone }}</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-900">{{ $electrician->license_number ?? 'N/A' }}</div>
        <div class="text-sm text-gray-500">{{ $electrician->years_experience ?? 0 }} years exp.</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm font-semibold text-[#3b82f6]">${{ number_format($electrician->hourly_rate, 2) }}/hr</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        @if($electrician->is_verified)
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                Verified
            </span>
        @else
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">
                Pending
            </span>
        @endif

        @if($electrician->is_suspended ?? false)
            <span class="ml-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                Suspended
            </span>
        @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('admin.electricians.show', $electrician) }}" 
               class="text-[#3b82f6] hover:text-[#2563eb]" title="View">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </a>
            <a href="{{ route('admin.electricians.edit', $electrician) }}" 
               class="text-indigo-600 hover:text-indigo-900" title="Edit">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </a>
            @if(!$electrician->is_verified)
                <form method="POST" action="{{ route('admin.electricians.verify', $electrician) }}" class="inline">
                    @csrf
                    <button type="submit" class="text-green-600 hover:text-green-900" title="Verify">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </button>
                </form>
            @endif
        </div>
    </td>
</tr>