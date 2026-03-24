@extends('layouts.app')

@section('title', 'Message Sent')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-12 text-center max-w-2xl mx-auto">
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-check-circle text-green-500 text-4xl"></i>
        </div>
        
        <h1 class="text-3xl font-bold text-[#1e3a5f] mb-4">Message Sent!</h1>
        <p class="text-gray-600 mb-8">
            Thank you for contacting us. We've received your message and will get back to you within 24 hours.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('home') }}" 
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#1e3a5f] to-[#3b82f6] text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                <i class="fas fa-home mr-2"></i>
                Return Home
            </a>
            <a href="{{ route('services.index') }}" 
                class="inline-flex items-center px-6 py-3 bg-gray-100 text-[#1e3a5f] font-bold rounded-xl hover:bg-gray-200 transition">
                <i class="fas fa-bolt mr-2"></i>
                Browse Services
            </a>
        </div>
    </div>
</div>
@endsection