@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- HERO SECTION with Electrical Background -->
    <div class="relative mb-12 overflow-hidden rounded-3xl">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=1920&q=80" 
                 alt="Electrical panel and wires" 
                 class="w-full h-full object-cover">
            <!-- Dark overlay for text readability -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#1e3a5f]/90 to-[#3b82f6]/80"></div>
            <!-- Electrical circuit pattern overlay -->
            <div class="absolute inset-0 opacity-20" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cpath d=\"M30 0 L30 60 M0 30 L60 30 M15 15 L45 45 M45 15 L15 45\" stroke=\"white\" stroke-width=\"0.5\" fill=\"none\" opacity=\"0.5\"/%3E%3C/svg%3E'); background-repeat: repeat;"></div>
        </div>
        
        <div class="relative px-8 py-16 md:py-20 text-center">
            <!-- Decorative electrical elements -->
            <div class="absolute top-4 left-4 w-16 h-16 text-white/20">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div class="absolute bottom-4 right-4 w-20 h-20 text-white/20 transform rotate-45">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 drop-shadow-lg">
                📞 Contact Us
            </h1>
            <p class="text-lg text-white/95 max-w-2xl mx-auto font-medium drop-shadow">
                Have questions about electrical services? We're here to help! Reach out to our support team.
            </p>
            
            <!-- Decorative elements -->
            <div class="absolute top-0 left-0 w-32 h-32 bg-white/10 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-48 h-48 bg-white/10 rounded-full translate-x-1/4 translate-y-1/4"></div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-8 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-xl flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Error Message -->
    @if($errors->any())
        <div class="mb-8 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-xl">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                <span class="font-semibold">Please fix the following errors:</span>
            </div>
            <ul class="list-disc list-inside text-sm ml-6">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- CONTACT GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <!-- Contact Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8">
                <h2 class="text-2xl font-bold text-[#1e3a5f] mb-2">Send us a Message</h2>
                <p class="text-gray-600 mb-6">Fill out the form below and we'll get back to you within 24 hours.</p>
                
                <form action="{{ route('contact.send') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Your Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#3b82f6] focus:ring focus:ring-[#3b82f6]/20 transition @error('name') border-red-500 @enderror"
                                   placeholder="John Doe"
                                   required>
                            @error('name')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email') }}"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#3b82f6] focus:ring focus:ring-[#3b82f6]/20 transition @error('email') border-red-500 @enderror"
                                   placeholder="john@example.com"
                                   required>
                            @error('email')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Subject -->
                    <div class="mb-6">
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                            Subject <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="subject" 
                               id="subject" 
                               value="{{ old('subject') }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#3b82f6] focus:ring focus:ring-[#3b82f6]/20 transition @error('subject') border-red-500 @enderror"
                               placeholder="How can we help you?"
                               required>
                        @error('subject')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div class="mb-6">
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            Message <span class="text-red-500">*</span>
                        </label>
                        <textarea name="message" 
                                  id="message" 
                                  rows="6" 
                                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-[#3b82f6] focus:ring focus:ring-[#3b82f6]/20 transition @error('message') border-red-500 @enderror"
                                  placeholder="Please describe your issue or question in detail..."
                                  required>{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-between">
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#1e3a5f] to-[#3b82f6] text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 group">
                            <i class="fas fa-paper-plane mr-2"></i>
                            <span>Send Message</span>
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </button>
                        <p class="text-xs text-gray-500">
                            <i class="fas fa-clock mr-1"></i> Avg. response: &lt; 2 hours
                        </p>
                    </div>
                </form>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="lg:col-span-1">
            <div class="bg-gradient-to-b from-white to-gray-50/50 rounded-2xl shadow-xl border border-gray-200 p-6 sticky top-24">
                <h3 class="font-bold text-[#1e3a5f] text-lg mb-6">Contact Information</h3>
                
                <!-- Phone -->
                <div class="flex items-start gap-4 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg flex-shrink-0">
                        <i class="fas fa-phone-alt text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Call us</p>
                        <a href="tel:+1234567890" class="text-sm font-semibold text-[#1e3a5f] hover:text-[#3b82f6] transition">
                            +27 (82) 086-2083
                        </a>
                        <p class="text-xs text-gray-400 mt-1">Mon-Fri, 8am-8pm</p>
                    </div>
                </div>

                <!-- Email -->
                <div class="flex items-start gap-4 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg flex-shrink-0">
                        <i class="fas fa-envelope text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Email us</p>
                        <a href="mailto:support@electrobook.test" class="text-sm font-semibold text-[#1e3a5f] hover:text-[#3b82f6] transition">
                            support@electrobook.test
                        </a>
                        <p class="text-xs text-gray-400 mt-1">24/7 support</p>
                    </div>
                </div>

                <!-- WhatsApp -->
                <div class="flex items-start gap-4 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg flex-shrink-0">
                        <i class="fab fa-whatsapp text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">WhatsApp</p>
                        <a href="https://wa.me/1234567890" target="_blank" class="text-sm font-semibold text-[#1e3a5f] hover:text-[#3b82f6] transition">
                            +27 (82) 086-2083
                        </a>
                        <p class="text-xs text-gray-400 mt-1">Quick responses</p>
                    </div>
                </div>

                <!-- Office -->
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg flex-shrink-0">
                        <i class="fas fa-map-marker-alt text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Office</p>
                        <p class="text-sm font-semibold text-[#1e3a5f]">
                            17 Tulleken Villa<br>
                            36 Tulleken Street<br>
                            Pretoria, South Africa 0001
                        </p>
                    </div>
                </div>

                <!-- Business Hours Card -->
                <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-100">
                    <h4 class="text-xs font-semibold text-blue-900 mb-3">Business Hours</h4>
                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Monday - Friday</span>
                            <span class="font-semibold text-[#1e3a5f]">8:00 AM - 8:00 PM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Saturday</span>
                            <span class="font-semibold text-[#1e3a5f]">9:00 AM - 5:00 PM</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sunday</span>
                            <span class="font-semibold text-[#1e3a5f]">10:00 AM - 3:00 PM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="mt-16 mb-4">
        <h2 class="text-2xl font-bold text-[#1e3a5f] text-center mb-8">Frequently Asked Questions</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <h3 class="font-semibold text-[#1e3a5f] mb-2 flex items-center">
                    <i class="fas fa-question-circle text-[#3b82f6] mr-2"></i>
                    How quickly do you respond?
                </h3>
                <p class="text-sm text-gray-600">We typically respond within 2 hours during business hours. For urgent matters, please call our support line.</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <h3 class="font-semibold text-[#1e3a5f] mb-2 flex items-center">
                    <i class="fas fa-question-circle text-[#3b82f6] mr-2"></i>
                    Do you offer emergency support?
                </h3>
                <p class="text-sm text-gray-600">Yes! For electrical emergencies, please call our 24/7 emergency line at +27 (82) 086-2083.</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <h3 class="font-semibold text-[#1e3a5f] mb-2 flex items-center">
                    <i class="fas fa-question-circle text-[#3b82f6] mr-2"></i>
                    How do I become an electrician?
                </h3>
                <p class="text-sm text-gray-600">Visit our "Become an Electrician" page or contact our partnerships team at partners@electrobook.test.</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
                <h3 class="font-semibold text-[#1e3a5f] mb-2 flex items-center">
                    <i class="fas fa-question-circle text-[#3b82f6] mr-2"></i>
                    What areas do you serve?
                </h3>
                <p class="text-sm text-gray-600">We currently serve all major metropolitan areas. Check our electrician listings for specific locations.</p>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="mt-16">
        <div class="bg-gray-200 rounded-2xl h-80 overflow-hidden shadow-lg">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14376.09165804074!2d28.208803!3d-25.746815!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1e95619c1b7b3b3b%3A0x5a4d6f7e8a9b0c1d!2s36%20Tulleken%20St%2C%20Arcadia%2C%20Pretoria%2C%200007%2C%20South%20Africa!5e0!3m2!1sen!2s!4v1234567890123!5m2!1sen!2s" 
                width="100%" 
                height="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy"
                title="Office location in Pretoria, South Africa">
            </iframe>
        </div>
        <p class="text-sm text-gray-500 mt-5  text-center">
            <i class="fas fa-map-marker-alt text-[#3b82f6] mr-1"></i> 
            Tulleken Villa, 36 Tulleken Street, Pretoria, South Africa
        </p>
    </div>

</div>
@endsection