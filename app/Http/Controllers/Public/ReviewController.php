<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Electrician;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of all reviews
     */

 
    public function index(Request $request)
    {
        // Get filter parameters
        $rating = $request->get('rating');
        $sort = $request->get('sort', 'latest');
        $search = $request->get('search');
        $electricianId = $request->get('electrician');
        
        // Start query with eager loading
        $reviews = Review::with(['client', 'electrician', 'booking'])
            ->whereNotNull('comment')
            ->where('comment', '!=', '');
        
        // Filter by rating
        if ($rating && in_array($rating, [1, 2, 3, 4, 5])) {
            $reviews->where('rating', $rating);
        }
        
        // Filter by electrician
        if ($electricianId) {
            $reviews->where('electrician_id', $electricianId);
        }
        
        // Search in comment content
        if ($search) {
            $reviews->where(function($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                ->orWhereHas('client', function($clientQuery) use ($search) {
                    $clientQuery->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('electrician', function($electricianQuery) use ($search) {
                    $electricianQuery->where('business_name', 'like', "%{$search}%");
                });
            });
        }
        
        // Apply sorting
        switch ($sort) {
            case 'rating_high':
                $reviews->orderBy('rating', 'desc');
                break;
            case 'rating_low':
                $reviews->orderBy('rating', 'asc');
                break;
            case 'oldest':
                $reviews->orderBy('created_at', 'asc');
                break;
            default:
                $reviews->orderBy('created_at', 'desc');
                break;
        }
        
        // Paginate results (12 per page)
        $reviews = $reviews->paginate(12);
        
        // Get statistics
        $totalReviews = Review::count();
        $averageRating = Review::avg('rating');
        
        // Get rating distribution
        $distribution = [
            5 => Review::where('rating', 5)->count(),
            4 => Review::where('rating', 4)->count(),
            3 => Review::where('rating', 3)->count(),
            2 => Review::where('rating', 2)->count(),
            1 => Review::where('rating', 1)->count(),
        ];
        
        // Get top rated electricians for filter 
        $topElectricians = Electrician::withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->whereHas('reviews', function($query) {
                $query->whereNotNull('comment');
            })
            ->orderBy('reviews_avg_rating', 'desc')
            ->limit(5)
            ->get();
        
        // Get recent reviews for sidebar
        $recentReviews = Review::with(['client', 'electrician'])
            ->whereNotNull('comment')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('public.reviews.index', compact(
            'reviews',
            'totalReviews',
            'averageRating',
            'distribution',
            'topElectricians',
            'recentReviews',
            'rating',
            'sort',
            'search',
            'electricianId'
        ));
    }

    /**
     * Display a single review
     */
    public function show(Review $review)
    {
        // Load relationships
        $review->load(['client', 'electrician', 'booking']);
        
        // Get other reviews from the same electrician
        $similarReviews = Review::where('electrician_id', $review->electrician_id)
            ->where('id', '!=', $review->id)
            ->with(['client'])
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        return view('public.reviews.show', compact('review', 'similarReviews'));
    }
    
    /**
     * Get reviews for a specific electrician (API endpoint)
     */
    public function electricianReviews(Electrician $electrician, Request $request)
    {
        $reviews = $electrician->reviews()
            ->with(['client'])
            ->whereNotNull('comment')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        if ($request->ajax()) {
            return response()->json($reviews);
        }
        
        return view('public.reviews.electrician', compact('electrician', 'reviews'));
    }
    
    /**
     * Get review statistics for dashboard
     */
    public function statistics()
    {
        $stats = [
            'total' => Review::count(),
            'average' => round(Review::avg('rating') ?? 0, 1),
            'with_comments' => Review::whereNotNull('comment')->count(),
            'verified' => Review::whereHas('electrician', function($q) {
                $q->where('is_verified', true);
            })->count(),
        ];
        
        // Monthly trend (last 6 months)
        $monthlyTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $count = Review::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            
            $monthlyTrend[] = [
                'month' => $month->format('M Y'),
                'count' => $count,
            ];
        }
        
        return response()->json([
            'statistics' => $stats,
            'monthly_trend' => $monthlyTrend,
        ]);
    }
}