@extends('layouts.common')

@section('title', $blog->title . ' - HotelHub')

@section('content')
<!-- Blog Header -->
<section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('blogs.index') }}" class="inline-flex items-center text-white/80 hover:text-white mb-6">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Blogs
        </a>
        <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $blog->title }}</h1>
        <div class="flex items-center text-indigo-100 space-x-6">
            <span class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                {{ $blog->created_at->format('F d, Y') }}
            </span>
            @if($blog->user)
            <span class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                {{ $blog->user->name }}
            </span>
            @endif
        </div>
    </div>
</section>

<!-- Blog Content -->
<section class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Blog Image -->
        @if($blog->image)
        <div class="mb-8 rounded-xl overflow-hidden">
            <img src="{{ $blog->image }}" alt="{{ $blog->title }}" class="w-full h-auto">
        </div>
        @endif

        <!-- Blog Body -->
        <article class="prose prose-lg max-w-none">
            {!! $blog->content !!}
        </article>

        <!-- Share Section -->
        <div class="mt-12 pt-8 border-t border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Share this article</h3>
            <div class="flex space-x-4">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                    Facebook
                </button>
                <button class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-lg transition">
                    Twitter
                </button>
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">
                    LinkedIn
                </button>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-8">
            <a href="{{ route('blogs.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to All Blogs
            </a>
        </div>
    </div>
</section>
@endsection
