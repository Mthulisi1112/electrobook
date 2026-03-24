<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        $categories = Category::with(['children' => function($query) {
            $query->active()->ordered();
        }])
        ->parents()
        ->active()
        ->ordered()
        ->get();

        // Group by type for the Thumbtack layout
        $groupedCategories = [
            'Interior' => $categories->where('type', 'interior'),
            'Exterior' => $categories->where('type', 'exterior'),
            'General Contracting' => $categories->where('type', 'contracting'),
        ];

        return view('public.categories.index', compact('groupedCategories'));
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
        if (!$category->is_active) {
            abort(404);
        }

        $category->load([
            'children' => function($query) {
                $query->active()->ordered();
            },
            'services' => function($query) {
                $query->active()->take(10);
            }
        ]);

        $services = Service::whereHas('categories', function($query) use ($category) {
            $query->where('categories.id', $category->id);
        })
        ->active()
        ->paginate(12);

        return view('public.categories.show', compact('category', 'services'));
    }

    /**
     * Get subcategories for a category (API endpoint for dynamic loading)
     */
    public function subcategories(Category $category)
    {
        $subcategories = $category->children()
            ->active()
            ->ordered()
            ->get();

        return response()->json($subcategories);
    }
}