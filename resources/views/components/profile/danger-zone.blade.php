@props(['user'])

<section id="delete-account" class="bg-white rounded-xl shadow-lg p-6 mt-6 scroll-mt-20 border-2 border-red-200">
    <h2 class="text-xl font-semibold text-red-600 mb-4 flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
        </svg>
        Danger Zone
    </h2>
    
    <div class="bg-red-50 rounded-lg p-4 mb-4">
        <p class="text-sm text-red-800">
            <strong>Warning:</strong> Deleting your account is permanent and cannot be undone. 
            All your data will be permanently removed from our servers.
        </p>
    </div>

    @if(
        ($user->isClient() && $user->clientBookings()->whereIn('status', ['pending', 'confirmed'])->exists()) ||
        ($user->isElectrician() && $user->electrician && $user->electrician->bookings()->whereIn('status', ['pending', 'confirmed'])->exists())
    )
        <div class="bg-amber-50 border-l-4 border-amber-400 p-4 mb-4">
            <div class="flex">
                <div class="shrink-0">
                    <svg class="h-5 w-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-amber-700">
                        You have active bookings. Please cancel or complete them before deleting your account.
                    </p>
                </div>
            </div>
        </div>
    @else
        <form method="POST" action="{{ route('profile.destroy') }}" 
              onsubmit="return confirmDeletion(event);">
            @csrf
            @method('DELETE')

            <div class="mb-4">
                <label for="delete-password" class="block text-sm font-medium text-gray-700 mb-1">
                    Please enter your password to confirm
                </label>
                <input type="password" 
                       name="password" 
                       id="delete-password" 
                       class="w-full md:w-1/2 rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                       required>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center space-x-3">
                <button type="submit" 
                        class="inline-flex items-center px-6 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Permanently Delete Account
                </button>
                
                <button type="button" 
                        onclick="showCancelModal()"
                        class="text-sm text-gray-600 hover:text-gray-800">
                    I've changed my mind
                </button>
            </div>
        </form>
    @endif
</section>

<script>
function confirmDeletion(event) {
    event.preventDefault();
    
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50';
    modal.innerHTML = `
        <div class="bg-white rounded-xl p-6 max-w-md w-full">
            <h3 class="text-lg font-semibold text-red-600 mb-4">Final Warning</h3>
            <p class="text-sm text-gray-600 mb-4">
                Are you absolutely sure you want to delete your account? This action cannot be undone and all your data will be permanently lost.
            </p>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="this.closest('.fixed').remove()" 
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="button" onclick="document.getElementById('delete-password').form.submit()" 
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Yes, Delete My Account
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    return false;
}
</script>