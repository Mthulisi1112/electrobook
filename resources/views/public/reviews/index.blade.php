@extends('layouts.app')

@section('title', 'Customer Reviews - ElectroBook')

@section('content')
<div class="min-h-screen" style="background: linear-gradient(135deg, #f5f0e6 0%, #e8e0d3 50%, #d9cfbf 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">Customer Reviews</h1>
            <p class="text-lg text-gray-600">What our customers say about our electricians</p>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl p-6 text-center shadow-sm">
                <div class="text-4xl font-bold text-amber-600 mb-2">{{ number_format($averageRating, 1) }}</div>
                <div class="flex justify-center mb-2">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-5 h-5 {{ $i <= round($averageRating) ? 'text-amber-500 fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>
                <p class="text-sm text-gray-500">Based on {{ number_format($totalReviews) }} reviews</p>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <h3 class="font-semibold text-gray-800 mb-3">Rating Distribution</h3>
                <div class="space-y-2">
                    @foreach([5,4,3,2,1] as $star)
                        @php
                            $count = $distribution[$star] ?? 0;
                            $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                        @endphp
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-600 w-8">{{ $star }}★</span>
                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-amber-500 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="text-xs text-gray-500 w-12">{{ $count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <h3 class="font-semibold text-gray-800 mb-3">Top Rated Electricians</h3>
                <div class="space-y-3">
                    @foreach($topElectricians->take(3) as $electrician)
                        <a href="{{ route('electricians.show', $electrician) }}" class="flex items-center justify-between hover:bg-gray-50 p-2 rounded-lg transition">
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $electrician->business_name }}</p>
                                <div class="flex items-center text-xs">
                                    <div class="flex text-amber-500">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= round($electrician->reviews_avg_rating ?? 0))
                                                ★
                                            @else
                                                ☆
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-gray-500 ml-1">({{ $electrician->reviews_count }})</span>
                                </div>
                            </div>
                            <span class="text-xs text-amber-600">View →</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <form method="GET" action="{{ route('reviews.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                        <input type="text" 
                               name="search" 
                               value="{{ $search }}"
                               placeholder="Search reviews..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    
                    <!-- Rating Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                        <select name="rating" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                            <option value="">All Ratings</option>
                            <option value="5" {{ $rating == 5 ? 'selected' : '' }}>★★★★★ (5 stars)</option>
                            <option value="4" {{ $rating == 4 ? 'selected' : '' }}>★★★★☆ (4+ stars)</option>
                            <option value="3" {{ $rating == 3 ? 'selected' : '' }}>★★★☆☆ (3+ stars)</option>
                            <option value="2" {{ $rating == 2 ? 'selected' : '' }}>★★☆☆☆ (2+ stars)</option>
                            <option value="1" {{ $rating == 1 ? 'selected' : '' }}>★☆☆☆☆ (1+ stars)</option>
                        </select>
                    </div>
                    
                    <!-- Sort -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sort by</label>
                        <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500">
                            <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>Latest First</option>
                            <option value="oldest" {{ $sort == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="rating_high" {{ $sort == 'rating_high' ? 'selected' : '' }}>Highest Rating</option>
                            <option value="rating_low" {{ $sort == 'rating_low' ? 'selected' : '' }}>Lowest Rating</option>
                        </select>
                    </div>
                    
                    <!-- Submit -->
                    <div class="flex items-end">
                        <button type="submit" class="w-full px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition">
                            Apply Filters
                        </button>
                    </div>
                </div>
                
                @if($search || $rating || $electricianId)
                    <div class="flex justify-end">
                        <a href="{{ route('reviews.index') }}" class="text-sm text-amber-600 hover:text-amber-700">
                            Clear all filters
                        </a>
                    </div>
                @endif
            </form>
        </div>
        
        <!-- Reviews Grid -->
        @if($reviews->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($reviews as $review)
                    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition">
                        <div class="flex items-start gap-4">
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
                                <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-200">
                                    @if($review->client && $review->client->profile_photo_path)
                                        <img src="{{ Storage::url($review->client->profile_photo_path) }}" 
                                             alt="{{ $clientName }}" 
                                             class="w-full h-full object-cover"
                                             onerror="this.onerror=null; this.src='{{ $avatarUrl }}'">
                                    @else
                                        <img src="{{ $avatarUrl }}" alt="{{ $clientName }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ $clientName }}</h3>
                                        <div class="flex items-center gap-2 mt-1">
                                            <div class="flex text-amber-500">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">★</svg>
                                                    @else
                                                        <svg class="w-4 h-4 fill-current text-gray-300" viewBox="0 0 20 20">★</svg>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="text-xs text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <p class="text-gray-600 mb-3 line-clamp-3">"{{ $review->comment }}"</p>
                                
                                @if($review->electrician)
                                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs text-gray-500">Service by:</span>
                                            <a href="{{ route('electricians.show', $review->electrician) }}" class="text-sm font-medium text-amber-600 hover:text-amber-700">
                                                {{ $review->electrician->business_name }}
                                            </a>
                                        </div>
                                        <a href="{{ route('reviews.show', $review) }}" class="text-xs text-amber-600 hover:text-amber-700">
                                            Read more →
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $reviews->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        @else
            <div class="bg-white rounded-xl p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">No reviews found</h3>
                <p class="text-gray-500">Try adjusting your filters or check back later.</p>
            </div>
        @endif
    </div>
</div>
@endsection