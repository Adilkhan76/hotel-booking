@extends('layouts.common')

@section('title', $hotel->name . ' - HotelHub')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $hotel->name }}</h1>
                <div class="flex items-center text-indigo-100">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    {{ $hotel->address }}, {{ $hotel->city }}, {{ $hotel->country }}
                </div>
            </div>
            <a href="{{ route('hotels.index') }}" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition">
                ← Back to Hotels
            </a>
        </div>
    </div>
</section>

<!-- Hotel Details -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Hotel Image -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                    @if($hotel->image)
                        <img src="{{ $hotel->image }}" alt="{{ $hotel->name }}" class="w-full h-80 object-cover">
                    @else
                        <div class="w-full h-80 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                            <svg class="w-24 h-24 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Hotel Info -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">About This Hotel</h2>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            {{ $hotel->phone }}
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ $hotel->email }}
                        </div>
                    </div>
                    <p class="text-gray-600">
                        {{ $hotel->description ?? 'Welcome to ' . $hotel->name . '. We offer luxurious accommodations with excellent amenities and services to make your stay memorable.' }}
                    </p>
                </div>

                <!-- Rooms Section -->
                @if($hotel->rooms && $hotel->rooms->count() > 0)
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Available Rooms</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($hotel->rooms as $room)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $room->room_number }} - {{ $room->room_type }}</h3>
                                    <p class="text-sm text-gray-500">Capacity: {{ $room->capacity }} guests</p>
                                </div>
                                <span class="text-lg font-bold text-indigo-600">${{ number_format($room->price_per_night, 2) }}/night</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $room->description }}</p>
                            @auth
                            <a href="{{ route('book') }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                Book This Room
                            </a>
                            @else
                            <a href="{{ route('login') }}" class="block w-full text-center bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                Login to Book
                            </a>
                            @endauth
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div>
                <!-- Booking Card -->
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Ready to Book?</h3>
                    <p class="text-gray-600 mb-6">
                        Experience luxury and comfort at {{ $hotel->name }}. Book your stay today!
                    </p>
                    @auth
                    <a href="{{ route('book') }}" class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white text-center px-6 py-3 rounded-lg font-medium transition mb-3">
                        Book Now
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white text-center px-6 py-3 rounded-lg font-medium transition mb-3">
                        Login to Book
                    </a>
                    <a href="{{ route('register') }}" class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-900 text-center px-6 py-3 rounded-lg font-medium transition">
                        Register
                    </a>
                    @endauth
                </div>

                <!-- Contact Card -->
                <div class="bg-white rounded-xl shadow-lg p-6 mt-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Contact Us</h3>
                    <div class="space-y-3">
                        <div class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            {{ $hotel->phone }}
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg class="w-5 h-5 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            {{ $hotel->email }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
