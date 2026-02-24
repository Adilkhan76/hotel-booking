@extends('layouts.common')

@section('title', 'Dashboard - HotelHub')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Dashboard Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            @if(isset($greeting))
                {{ $greeting }}, {{ Auth::user()->name }}!
            @else
                Welcome, {{ Auth::user()->name }}!
            @endif
        </h1>
        <p class="text-gray-600 mt-2">
            @switch(Auth::user()->role)
                @case('super_admin')
                    Welcome to the Admin Dashboard. Manage all aspects of your hotel booking system.
                @case('manager')
                    Welcome to the Manager Dashboard. View and manage your hotel operations.
                @case('receptionist')
                    Welcome to the Receptionist Dashboard. Handle guest check-ins and bookings.
                @case('waiter')
                    Welcome to the Waiter Dashboard. View your assigned tasks.
                @case('cook')
                    Welcome to the Cook Dashboard. Manage kitchen orders and preparations.
                @default
                    Welcome to your Dashboard. Manage your bookings and profile.
            @endswitch
        </p>
    </div>

    <!-- Super Admin Dashboard -->
    @if(Auth::user()->role === 'super_admin')
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Hotels</p>
                        <p class="text-3xl font-bold text-indigo-600">{{ $totalHotels ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Users</p>
                        <p class="text-3xl font-bold text-green-600">{{ $totalUsers ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Bookings</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $totalBookings ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Revenue</p>
                        <p class="text-3xl font-bold text-purple-600">$0</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Status Breakdown -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Booked</h3>
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">{{ $bookedCount ?? 0 }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ ($totalBookings ?? 1) > 0 ? round($bookedCount / $totalBookings * 100) : 0 }}%;"></div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Cancelled</h3>
                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">{{ $cancelledCount ?? 0 }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-red-500 h-2 rounded-full" style="width: {{ ($totalBookings ?? 1) > 0 ? round($cancelledCount / $totalBookings * 100) : 0 }}%;"></div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Successful</h3>
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">{{ $successfulCount ?? 0 }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ ($totalBookings ?? 1) > 0 ? round($successfulCount / $totalBookings * 100) : 0 }}%"></div>
                </div>
            </div>
        </div>

        <!-- Quick Actions for Admin -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('admin.bookings.index') }}" class="flex flex-col items-center p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition">
                    <svg class="w-8 h-8 text-indigo-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-700">Manage Bookings</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                    <svg class="w-8 h-8 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-700">Manage Users</span>
                </a>
                <a href="{{ route('admin.hotels.index') }}" class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                    <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-700">Manage Hotels</span>
                </a>
                <a href="{{ route('admin.blogs.index') }}" class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                    <svg class="w-8 h-8 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-700">Manage Blogs</span>
                </a>
            </div>
        </div>

    <!-- Employee Dashboard (Manager, Receptionist, Waiter, Cook) -->
    @elseif(in_array(Auth::user()->role, ['manager', 'receptionist', 'waiter', 'cook']))
        <div class="bg-white rounded-xl shadow-md p-8 text-center">
            <div class="flex items-center justify-center mb-4">
                <span class="text-5xl mr-4">⏰</span>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">
                {{ $greeting }}, {{ Auth::user()->name }}!
            </h2>
            <p class="text-gray-500 mt-2 capitalize">{{ Auth::user()->role }}</p>
        </div>

    <!-- Normal User Dashboard -->
    @else
        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <a href="{{ route('book') }}" class="bg-white rounded-xl shadow-md p-6 flex items-center justify-center hover:bg-indigo-50 transition">
                <svg class="w-6 h-6 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span class="font-medium text-gray-900">Book a Room</span>
            </a>
            <a href="#bookings" class="bg-white rounded-xl shadow-md p-6 flex items-center justify-center hover:bg-indigo-50 transition">
                <svg class="w-6 h-6 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="font-medium text-gray-900">My Bookings</span>
            </a>
            <a href="#profile" class="bg-white rounded-xl shadow-md p-6 flex items-center justify-center hover:bg-indigo-50 transition">
                <svg class="w-6 h-6 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="font-medium text-gray-900">My Profile</span>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Bookings Section -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden" id="bookings">
                <div class="border-b border-gray-200 p-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">My Bookings</h3>
                        <a href="{{ route('book') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                            Book New Room →
                        </a>
                    </div>
                </div>

                <div class="p-4">
                    @if(isset($bookings) && $bookings->count() > 0)
                        <div class="space-y-4">
                            @foreach($bookings as $booking)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Booking #{{ $booking->id }}</h4>
                                        <p class="text-sm text-gray-600">{{ $booking->room->hotel->name ?? 'N/A' }}</p>
                                    </div>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                        @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                                <div class="text-sm text-gray-600 mb-2">
                                    <p>Room: {{ $booking->room->name ?? 'N/A' }}</p>
                                    <p>Check-in: {{ $booking->check_in }} | Check-out: {{ $booking->check_out }}</p>
                                </div>
                                <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-100">
                                    <span class="font-semibold text-gray-900">${{ number_format($booking->total_price, 2) }}</span>
                                    @if($booking->status === 'confirmed')
                                    <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                            Cancel Booking
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <h4 class="text-sm font-medium text-gray-900 mb-1">No Bookings Yet</h4>
                            <p class="text-xs text-gray-500 mb-3">Start planning your next trip!</p>
                            <a href="{{ route('book') }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-xs rounded-lg hover:bg-indigo-700 transition">
                                Book Your First Room
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Profile Section -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden" id="profile">
                <div class="border-b border-gray-200 p-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">My Profile</h3>
                        <a href="{{ route('profile.edit') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                            Edit Profile →
                        </a>
                    </div>
                </div>

                <div class="p-4">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center">
                            <span class="text-2xl font-bold text-indigo-600">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-gray-900">{{ Auth::user()->name }}</h4>
                            <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Full Name</label>
                            <p class="text-sm text-gray-900 mt-1">{{ Auth::user()->name }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Email Address</label>
                            <p class="text-sm text-gray-900 mt-1">{{ Auth::user()->email }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Account Type</label>
                            <p class="text-sm text-gray-900 mt-1 capitalize">{{ Auth::user()->role ?? 'Customer' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Member Since</label>
                            <p class="text-sm text-gray-900 mt-1">{{ Auth::user()->created_at->format('F d, Y') }}</p>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <a href="{{ route('profile.edit') }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                            Update Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Summary -->
        @if(isset($bookings) && $bookings->count() > 0)
        <div class="mt-8 bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Booking Summary</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center">
                    <p class="text-2xl font-bold text-indigo-600">{{ $bookings->count() }}</p>
                    <p class="text-sm text-gray-500">Total Bookings</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-green-600">{{ $bookings->where('status', 'confirmed')->count() }}</p>
                    <p class="text-sm text-gray-500">Confirmed</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-red-600">{{ $bookings->where('status', 'cancelled')->count() }}</p>
                    <p class="text-sm text-gray-500">Cancelled</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($bookings->sum('total_price'), 2) }}</p>
                    <p class="text-sm text-gray-500">Total Spent</p>
                </div>
            </div>
        </div>
        @endif
    @endif
</div>
@endsection
