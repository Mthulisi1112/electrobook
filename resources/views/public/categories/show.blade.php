@extends('layouts.app')

@section('content')
<div class="bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        
        <!-- Breadcrumb -->
        <div class="flex items-center text-xs text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-gray-700">Home</a>
            <svg class="w-3 h-3 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="{{ route('categories.index') }}" class="hover:text-gray-700">Categories</a>
            <svg class="w-3 h-3 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="font-medium text-gray-700">{{ $category->name }}</span>
        </div>

        <!-- Hero Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-light text-gray-900 mb-3">{{ $category->name }}</h1>
            @if($category->description)
                <p class="text-sm text-gray-600 max-w-3xl">{{ $category->description }}</p>
            @endif
        </div>

        <!-- Subcategories Grid -->
        @if($category->children->count() > 0)
        <div class="mb-8">
            <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Subcategories</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                @foreach($category->children as $child)
                    <a href="{{ route('categories.show', $child) }}" class="px-3 py-2 bg-gray-50 hover:bg-gray-100 rounded-lg text-xs text-gray-700 transition">
                        {{ $child->name }}
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Services List -->
        @if($services->count() > 0)
        <div>
            <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Services in {{ $category->name }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($services as $service)
                    <a href="{{ route('services.show', $service) }}" class="block p-4 border border-gray-200 rounded-lg hover:shadow-sm transition">
                        <h3 class="text-sm font-medium text-gray-900">{{ $service->name }}</h3>
                        @if($service->description)
                            <p class="text-xs text-gray-500 mt-1">{{ Str::limit($service->description, 60) }}</p>
                        @endif
                        <span class="text-xs text-[#1e3a5f] mt-2 inline-block">View details →</span>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $services->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection