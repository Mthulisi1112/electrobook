@extends('layouts.app')

@section('title', 'My Reviews')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('electrician.dashboard') }}" class="text-[#3b82f6] hover:text-[#2563eb] flex items-center mb-4">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Dashboard
        </a>
        <h1 class="text-3xl font-bold text-[#1e3a5f]">Client Reviews</h1>
        <p class="text-gray-600 mt-2">See what clients are saying about your work</p>
    </div>

    <!-- Rating Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Overall Rating -->
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-sm text-gray-500 mb-2">Overall Rating</p>
            <p class="text-5xl font-bold text-[#1e3a5f]">{{ number_format($rating_stats['average'], 1) }}</p>
            <div class="flex justify-center text-amber-400 text-2xl my-3">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= round($rating_stats['average']))
                        ★
                    @else
                        ☆
                    @endif
                @endfor
            </div>
            <p class="text-sm text-gray-600">Based on {{ $rating_stats['total'] }} reviews</p>
        </div>

        <!-- Rating Breakdown -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-[#1e3a5f] mb-4">Rating Breakdown</h3>
            <div class="space-y-3">
                @foreach([5,4,3,2,1] as $star)
                    @php
                        $count = $rating_stats[$star . '_star'];
                        $percentage = $rating_stats['total'] > 0 ? ($count / $rating_stats['total']) * 100 : 0;
                    @endphp
                    <div class="flex items-center">
                        <span class="text-sm font-medium text-gray-700 w-12">{{ $star }} ★</span>
                        <div class="flex-1 mx-4">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="h-2 rounded-full bg-amber-400" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                        <span class="text-sm text-gray-600 w-12">{{ $count }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Reviews List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-[#1e3a5f]">All Reviews</h2>
        </div>

        @if($reviews->isNotEmpty())
            <div class="divide-y divide-gray-200">
                @foreach($reviews as $review)
                    <div class="p-6 hover:bg-gray-50 transition">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-[#1e3a5f] flex items-center justify-center text-white font-bold">
                                    {{ substr($review->client->name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900">{{ $review->client->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $review->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div class="flex text-amber-400">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 fill-current text-gray-300" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        
                        @if($review->comment)
                            <p class="text-gray-700 mt-2">"{{ $review->comment }}"</p>
                        @else
                            <p class="text-gray-400 italic mt-2">No comment provided</p>
                        @endif

                        @if($review->booking)
                            <p class="text-xs text-gray-400 mt-3">
                                Service: {{ $review->booking->service->name }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $reviews->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linecap="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No reviews yet</h3>
                <p class="mt-1 text-sm text-gray-500">When clients review your work, they'll appear here.</p>
            </div>
        @endif
    </div>

    <!-- Tips for Getting More Reviews -->
    @if($reviews->isEmpty())
        <div class="mt-8 bg-blue-50 rounded-lg p-6">
            <h3 class="text-sm font-medium text-blue-800 mb-3">Tips for Getting Reviews</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-start space-x-3">
                    <div class="shrink-0">
                        <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 text-sm">1</span>
                        </div>
                    </div>
                    <p class="text-sm text-blue-700">Provide excellent service and communicate clearly with clients.</p>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="shrink-0">
                        <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 text-sm">2</span>
                        </div>
                    </div>
                    <p class="text-sm text-blue-700">Follow up after job completion and politely ask for feedback.</p>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="shrink-0">
                        <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 text-sm">3</span>
                        </div>
                    </div>
                    <p class="text-sm text-blue-700">Be responsive and professional throughout the booking process.</p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection