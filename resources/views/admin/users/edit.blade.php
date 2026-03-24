@extends('layouts.app')

@section('title', 'Edit ' . $user->name)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('admin.users.index') }}" class="text-[#3b82f6] hover:text-[#2563eb] flex items-center mb-4">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Users
        </a>
        <h1 class="text-3xl font-bold text-[#1e3a5f]">Edit User</h1>
        <p class="text-gray-600 mt-2">{{ $user->name }}</p>
    </div>

    <!-- Status Banner for Unverified Users -->
    @if(!$user->hasVerifiedEmail())
        <div class="bg-amber-50 border-l-4 border-amber-400 p-4 mb-8">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-amber-700">
                        This user's email is not verified. 
                        <a href="#" onclick="event.preventDefault(); document.getElementById('verify-form').submit();" class="font-medium underline text-amber-700 hover:text-amber-600">
                            Click here to verify now.
                        </a>
                    </p>
                </div>
            </div>
        </div>
        <form id="verify-form" method="POST" action="{{ route('admin.users.verify-email', $user) }}" class="hidden">
            @csrf
        </form>
    @endif

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name', $user->name) }}" 
                       required
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                <input type="email" 
                       name="email" 
                       id="email" 
                       value="{{ old('email', $user->email) }}" 
                       required
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div class="mb-6">
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                <input type="text" 
                       name="phone" 
                       id="phone" 
                       value="{{ old('phone', $user->phone) }}" 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('phone') border-red-500 @enderror">
                @error('phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password (Optional) -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password (leave blank to keep current)</label>
                <input type="password" 
                       name="password" 
                       id="password" 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6] @error('password') border-red-500 @enderror">
                <p class="mt-1 text-xs text-gray-500">Minimum 8 characters. Only fill if you want to change the password.</p>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                <input type="password" 
                       name="password_confirmation" 
                       id="password_confirmation" 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#3b82f6] focus:ring-[#3b82f6]">
            </div>

            <!-- Role -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Role *</label>
                <div class="grid grid-cols-3 gap-4">
                    <label class="relative flex items-center justify-center p-4 border rounded-lg cursor-pointer hover:border-[#3b82f6] transition {{ old('role', $user->role) == 'admin' ? 'border-[#3b82f6] bg-purple-50' : 'border-gray-200' }}">
                        <input type="radio" name="role" value="admin" class="sr-only" {{ old('role', $user->role) == 'admin' ? 'checked' : '' }}>
                        <div class="text-center">
                            <svg class="w-8 h-8 mx-auto text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 019.5 8H8m4 0h1.5A2.5 2.5 0 0016 5.5V4m0 0h-3.5A2.5 2.5 0 0110 6.5V8"></path>
                            </svg>
                            <span class="block text-sm font-medium text-gray-900">Admin</span>
                        </div>
                    </label>

                    <label class="relative flex items-center justify-center p-4 border rounded-lg cursor-pointer hover:border-[#3b82f6] transition {{ old('role', $user->role) == 'electrician' ? 'border-[#3b82f6] bg-green-50' : 'border-gray-200' }}">
                        <input type="radio" name="role" value="electrician" class="sr-only" {{ old('role', $user->role) == 'electrician' ? 'checked' : '' }}>
                        <div class="text-center">
                            <svg class="w-8 h-8 mx-auto text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="block text-sm font-medium text-gray-900">Electrician</span>
                        </div>
                    </label>

                    <label class="relative flex items-center justify-center p-4 border rounded-lg cursor-pointer hover:border-[#3b82f6] transition {{ old('role', $user->role) == 'client' ? 'border-[#3b82f6] bg-blue-50' : 'border-gray-200' }}">
                        <input type="radio" name="role" value="client" class="sr-only" {{ old('role', $user->role) == 'client' ? 'checked' : '' }}>
                        <div class="text-center">
                            <svg class="w-8 h-8 mx-auto text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="block text-sm font-medium text-gray-900">Client</span>
                        </div>
                    </label>
                </div>
                @error('role')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if($user->isElectrician() && $user->electrician)
                <!-- Electrician Profile Info (Read-only) -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Electrician Profile</h3>
                    <p class="text-sm text-gray-600">Business: {{ $user->electrician->business_name }}</p>
                    <p class="text-sm text-gray-600">License: {{ $user->electrician->license_number ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-600">Experience: {{ $user->electrician->years_experience ?? 0 }} years</p>
                    <p class="text-sm text-gray-600 mt-2">
                        <a href="{{ route('admin.electricians.edit', $user->electrician) }}" class="text-[#3b82f6] hover:text-[#2563eb]">
                            Edit Electrician Profile →
                        </a>
                    </p>
                </div>
            @endif

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-[#3b82f6] text-white rounded-md hover:bg-[#2563eb]">
                    Update User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection