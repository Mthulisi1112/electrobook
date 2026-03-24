@extends('layouts.app')

@section('title', 'Verify Email')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-[#1e3a5f]">
                Verify Your Email
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Almost there! Please verify your email address.
            </p>
        </div>

        <!-- Verification Message -->
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
            <div class="flex">
                <div class="shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        @if(session('resent'))
                            <span class="font-medium">A fresh verification link has been sent to your email address.</span>
                        @else
                            <span class="font-medium">Thanks for signing up!</span> Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we can send another.
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Resend Verification Form -->
        <div class="mt-8 bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf

                <p class="text-sm text-gray-600 mb-4">
                    Didn't receive the email? Check your spam folder or click below to resend.
                </p>

                <button type="submit" 
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#3b82f6] hover:bg-[#2563eb] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#3b82f6] transition">
                    Resend Verification Email
                </button>
            </form>

            <div class="mt-4 text-center">
                <a href="{{ route('profile.edit') }}" 
                   class="text-sm text-[#3b82f6] hover:text-[#2563eb]">
                    Back to Profile
                </a>
            </div>
        </div>

        <!-- Help Text -->
        <div class="text-center">
            <p class="text-xs text-gray-500">
                Having trouble? <a href="mailto:support@electrobook.com" class="text-[#3b82f6] hover:text-[#2563eb]">Contact Support</a>
            </p>
        </div>
    </div>
</div>
@endsection