@extends('layouts.app')

@section('title', config('cms.site.name', 'Admin Panel'))
@section('description', config('cms.site.description', 'A modern admin panel and CMS'))

@section('content')
<div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white">
    <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Welcome to {{ config('cms.site.name', 'Admin Panel') }}
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-primary-100">
                A modern, feature-rich admin dashboard and content management system
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('blog.index') }}" class="btn bg-white text-primary-600 hover:bg-gray-100">
                    Explore Blog
                </a>
                <a href="/admin" class="btn border-2 border-white text-white hover:bg-white hover:text-primary-600">
                    Admin Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Featured Posts -->
@if($featuredPosts->count() > 0)
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">Featured Posts</h2>
            <p class="text-lg text-gray-600 dark:text-gray-400">Discover our most popular content</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredPosts as $post)
            <article class="card hover:shadow-lg transition-shadow duration-300">
                @if($post->featured_image_url)
                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                @endif
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-2">
                        <span>{{ $post->published_at->format('M d, Y') }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $post->reading_time }} min read</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                        <a href="{{ route('blog.show', $post) }}" class="hover:text-primary-600 dark:hover:text-primary-400">
                            {{ $post->title }}
                        </a>
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $post->excerpt }}</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img src="{{ $post->author->avatar_url }}" alt="{{ $post->author->name }}" class="h-8 w-8 rounded-full mr-3">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $post->author->name }}</span>
                        </div>
                        <a href="{{ route('blog.show', $post) }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium">
                            Read More →
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Categories -->
@if($categories->count() > 0)
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">Explore Categories</h2>
            <p class="text-lg text-gray-600 dark:text-gray-400">Find content that interests you</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $category)
            <a href="{{ route('blog.category', $category) }}" class="card hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="p-6 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center" style="background-color: {{ $category->color }}20; color: {{ $category->color }}">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ $category->name }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $category->description }}</p>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $category->published_posts_count }} posts</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Recent Posts -->
@if($recentPosts->count() > 0)
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">Latest Posts</h2>
            <p class="text-lg text-gray-600 dark:text-gray-400">Stay updated with our newest content</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($recentPosts as $post)
            <article class="card hover:shadow-lg transition-shadow duration-300">
                @if($post->featured_image_url)
                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-40 object-cover">
                @endif
                <div class="p-4">
                    <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 mb-2">
                        <span>{{ $post->published_at->format('M d') }}</span>
                        @if($post->category)
                        <span class="mx-2">•</span>
                        <span class="px-2 py-1 rounded-full text-xs" style="background-color: {{ $post->category->color }}20; color: {{ $post->category->color }}">
                            {{ $post->category->name }}
                        </span>
                        @endif
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                        <a href="{{ route('blog.show', $post) }}" class="hover:text-primary-600 dark:hover:text-primary-400">
                            {{ Str::limit($post->title, 60) }}
                        </a>
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">{{ Str::limit($post->excerpt, 100) }}</p>
                </div>
            </article>
            @endforeach
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('blog.index') }}" class="btn btn-primary">View All Posts</a>
        </div>
    </div>
</section>
@endif
@endsection