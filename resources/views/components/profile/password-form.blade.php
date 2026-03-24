<section id="password" class="bg-white rounded-xl shadow-lg p-6 mt-6 scroll-mt-20">
    <h2 class="text-xl font-semibold text-[#1e3a5f] mb-6 flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
        </svg>
        Change Password
    </h2>
    
    <form method="POST" action="{{ route('profile.password.update') }}" class="space-y-6" id="passwordForm">
        @csrf
        @method('PUT')

        <!-- Current Password -->
        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
                Current Password <span class="text-red-500">*</span>
            </label>
            <input type="password" 
                   name="current_password" 
                   id="current_password" 
                   class="w-full md:w-1/2 rounded-lg border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('current_password') border-red-500 @enderror"
                   required>
            @error('current_password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- New Password -->
        <div x-data="{ showStrength: false, password: '' }">
            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">
                New Password <span class="text-red-500">*</span>
            </label>
            <input type="password" 
                   name="new_password" 
                   id="new_password" 
                   x-model="password"
                   @focus="showStrength = true"
                   class="w-full md:w-1/2 rounded-lg border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('new_password') border-red-500 @enderror"
                   required>
            
            <!-- Password Strength Indicator -->
            <div x-show="showStrength && password.length > 0" class="mt-2 md:w-1/2">
                <div class="flex items-center space-x-2">
                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full transition-all duration-300"
                             :class="{
                                 'bg-red-500 w-1/4': password.length > 0 && password.length < 8,
                                 'bg-yellow-500 w-2/4': password.length >= 8 && !/(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])/.test(password),
                                 'bg-green-500 w-full': password.length >= 8 && /(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])/.test(password)
                             }">
                        </div>
                    </div>
                    <span class="text-xs" x-text="
                        password.length < 8 ? 'Weak' : 
                        (/(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])/.test(password) ? 'Strong' : 'Medium')
                    "></span>
                </div>
                <p class="text-xs text-gray-500 mt-1">Minimum 8 characters with at least one uppercase, one number, and one special character.</p>
            </div>
            @error('new_password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm New Password -->
        <div>
            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                Confirm New Password <span class="text-red-500">*</span>
            </label>
            <input type="password" 
                   name="new_password_confirmation" 
                   id="new_password_confirmation" 
                   class="w-full md:w-1/2 rounded-lg border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6]"
                   required>
        </div>

        <div class="flex justify-end pt-4 border-t">
            <button type="submit" 
                    class="inline-flex items-center px-6 py-2.5 bg-[#3b82f6] text-white rounded-lg hover:bg-[#2563eb] transition shadow-sm hover:shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                Update Password
            </button>
        </div>
    </form>
</section>