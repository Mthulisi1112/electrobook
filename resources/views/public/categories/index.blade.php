@extends('layouts.app')

@section('content')
<div class="bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Breadcrumb -->
        <div class="flex items-center text-xs text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-gray-700">Home</a>
            <svg class="w-3 h-3 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="font-medium text-gray-700">Categories</span>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-light text-gray-900 mb-3">All Categories</h1>
            <p class="text-sm text-gray-600 max-w-3xl">Browse services by category to find the right professional for your needs.</p>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($groupedCategories as $groupName => $categories)
                @if($categories->count() > 0)
                <div>
                    <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">{{ $groupName }}</h2>
                    <div class="space-y-3">
                        @foreach($categories as $category)
                            <div>
                                <a href="{{ route('categories.show', $category) }}" class="block text-sm text-gray-700 hover:text-gray-900 hover:underline">
                                    {{ $category->name }}
                                </a>
                                @if($category->children->count() > 0)
                                    <div class="ml-3 mt-1 space-y-1">
                                        @foreach($category->children->take(3) as $child)
                                            <a href="{{ route('categories.show', $child) }}" class="block text-xs text-gray-500 hover:text-gray-700">
                                                {{ $child->name }}
                                            </a>
                                        @endforeach
                                        @if($category->children->count() > 3)
                                            <span class="text-xs text-gray-400">+{{ $category->children->count() - 3 }} more</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection