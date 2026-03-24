@props(['title', 'message', 'actionUrl', 'actionText'])

<div class="p-12 text-center">
    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
    </svg>
    <h3 class="mt-4 text-lg font-medium text-gray-900">{{ $title }}</h3>
    <p class="mt-2 text-sm text-gray-500 max-w-md mx-auto">{{ $message }}</p>
    @if($actionUrl && $actionText)
        <div class="mt-8">
            <a href="{{ $actionUrl }}" 
               class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#3b82f6] hover:bg-[#2563eb] transition shadow-sm hover:shadow-md">
                {{ $actionText }}
            </a>
        </div>
    @endif
</div>