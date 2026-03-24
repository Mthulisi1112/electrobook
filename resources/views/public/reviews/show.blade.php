@extends('layouts.app')

@section('title', 'Review by ' . ($review->client->name ?? 'Customer') . ' - ElectroBook')

@section('content')
<div class="min-h-screen" style="background: linear-gradient(135deg, #f5f0e6 0%, #e8e0d3 50%, #d9cfbf 100%);">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('reviews.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-amber-600 group">
                <svg class="w-4 h-4 mr-1 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to all reviews
            </a>
        </div>
        
        <!-- Review Card -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
            <div class="flex items-start gap-6">
                <!-- Avatar -->
                <div class="flex-shrink-0">
                    @php
                        $clientName = $review->client->name ?? 'Customer';
                        $initials = '';
                        $nameParts = explode(' ', $clientName);
                        foreach ($nameParts as $part) {
                            if (!empty($part)) {
                                $initials .= strtoupper(substr($part, 0, 1));
                            }
                        }
                        $avatarUrl = "https://ui-avatars.com/api/?background=6b7280&color=fff&bold=true&size=128&name=" . urlencode($initials);
                    @endphp
                    <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-200">
                        @if($review->client && $review->client->profile_photo_path)
                            <img src="{{ $review->client->profile_photo_path }}" 
                                 alt="{{ $clientName }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <img src="{{ $avatarUrl }}" alt="{{ $clientName }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                </div>
                
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $clientName }}</h1>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex text-amber-500">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">★</svg>
                                @else
                                    <svg class="w-6 h-6 fill-current text-gray-300" viewBox="0 0 20 20">★</svg>
                                @endif
                            @endfor
                        </div>
                        <span class="text-sm text-gray-500">{{ $review->created_at->format('F d, Y') }}</span>
                    </div>
                    
                    <p class="text-gray-700 text-lg leading-relaxed mb-6">"{{ $review->comment }}"</p>
                    
                    @if($review->electrician)
                        <div class="bg-amber-50 rounded-lg p-4 border-l-4 border-amber-600">
                            <p class="text-sm text-gray-600 mb-2">Service provided by:</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    @php
                                        $electricianName = $review->electrician->business_name ?? 'Electrician';
                                        $electricianInitial = strtoupper(substr($electricianName, 0, 1));
                                    @endphp
                                    <div class="w-10 h-10 rounded-full bg-amber-600 flex items-center justify-center text-white font-bold">
                                        {{ $electricianInitial }}
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ $electricianName }}</h3>
                                        <div class="flex items-center text-sm">
                                            <div class="flex text-amber-500">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= round($review->electrician->reviews_avg_rating ?? 0))
                                                        ★
                                                    @else
                                                        ☆
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="text-gray-500 ml-1">{{ $review->electrician->years_experience }} years exp.</span>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('electricians.show', $review->electrician) }}" class="px-4 py-2 bg-amber-600 text-white text-sm rounded-lg hover:bg-amber-700 transition">
                                    View Profile →
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Similar Reviews -->
        @if($similarReviews->isNotEmpty())
            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-4">More reviews from {{ $review->electrician->business_name ?? 'this electrician' }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($similarReviews as $similarReview)
                        <a href="{{ route('reviews.show', $similarReview) }}" class="bg-white rounded-xl shadow-sm p-4 hover:shadow-md transition">
                            <div class="flex items-center gap-3 mb-3">
                                @php
                                    $similarClientName = $similarReview->client->name ?? 'Customer';
                                    $similarInitials = '';
                                    $similarNameParts = explode(' ', $similarClientName);
                                    foreach ($similarNameParts as $part) {
                                        if (!empty($part)) {
                                            $similarInitials .= strtoupper(substr($part, 0, 1));
                                        }
                                    }
                                    $similarAvatar = "https://ui-avatars.com/api/?background=6b7280&color=fff&bold=true&size=128&name=" . urlencode($similarInitials);
                                @endphp
                                <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-200">
                                    <img src="{{ $similarAvatar }}" alt="{{ $similarClientName }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800 text-sm">{{ $similarClientName }}</h4>
                                    <div class="flex text-amber-500 text-xs">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $similarReview->rating)
                                                ★
                                            @else
                                                ☆
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm line-clamp-2">"{{ $similarReview->comment }}"</p>
                            <p class="text-xs text-gray-400 mt-2">{{ $similarReview->created_at->diffForHumans() }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection