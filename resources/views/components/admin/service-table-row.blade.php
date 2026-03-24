@props(['service'])

<tr class="hover:bg-gray-50 transition">
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center">
            <div class="shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                @if($service->icon)
                    <span class="text-xl">{{ $service->icon }}</span>
                @else
                    <svg class="w-6 h-6 text-[#3b82f6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                @endif
            </div>
            <div class="ml-4">
                <div class="text-sm font-medium text-gray-900">{{ $service->name }}</div>
                <div class="text-sm text-gray-500">{{ Str::limit($service->description, 50) }}</div>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
            {{ $service->category }}
        </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-900">${{ number_format($service->base_price, 2) }}</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-900">{{ $service->estimated_duration_minutes }} min</div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        @if($service->is_active)
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                Active
            </span>
        @else
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                Inactive
            </span>
        @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <div class="flex items-center justify-end space-x-3">
            <!-- Toggle Active/Inactive -->
            <form method="POST" action="{{ route('admin.services.toggle', $service) }}" class="inline">
                @csrf
                <button type="submit" 
                        class="text-{{ $service->is_active ? 'amber' : 'green' }}-600 hover:text-{{ $service->is_active ? 'amber' : 'green' }}-900"
                        title="{{ $service->is_active ? 'Deactivate' : 'Activate' }}">
                    @if($service->is_active)
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @endif
                </button>
            </form>

            <!-- Edit -->
            <a href="{{ route('admin.services.edit', $service) }}" 
               class="text-indigo-600 hover:text-indigo-900" title="Edit">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </a>

            <!-- Delete -->
            <form method="POST" action="{{ route('admin.services.destroy', $service) }}" 
                  onsubmit="return confirm('Are you sure you want to delete this service? This action cannot be undone.');"
                  class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="text-red-600 hover:text-red-900" 
                        title="Delete"
                        {{ $service->bookings()->exists() ? 'disabled' : '' }}>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </form>
        </div>
    </td>
</tr>