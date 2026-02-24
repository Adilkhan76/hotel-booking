<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hotel Booking')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">
                        HotelHub
                    </a>
                </div>

                <!-- Navigation Menu -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="{{ route('home') }}" class="{{ Request::routeIs('home') ? 'text-indigo-600' : 'text-gray-700' }} hover:text-indigo-600 px-3 py-2 font-medium">Home</a>
                    <a href="{{ route('about') }}" class="{{ Request::routeIs('about') ? 'text-indigo-600' : 'text-gray-700' }} hover:text-indigo-600 px-3 py-2 font-medium">About Us</a>
                    <a href="{{ route('services') }}" class="{{ Request::routeIs('services') ? 'text-indigo-600' : 'text-gray-700' }} hover:text-indigo-600 px-3 py-2 font-medium">Services</a>
                    <a href="{{ route('blogs.index') }}" class="{{ Request::routeIs('blogs.*') ? 'text-indigo-600' : 'text-gray-700' }} hover:text-indigo-600 px-3 py-2 font-medium">Blogs</a>
                    <a href="{{ route('contact') }}" class="{{ Request::routeIs('contact') ? 'text-indigo-600' : 'text-gray-700' }} hover:text-indigo-600 px-3 py-2 font-medium">Contact</a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition">Dashboard</a>
                        <form method="POST" action="{{ url('/logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-indigo-600 font-medium">Logout</button>
                        </form>
                    @else
                        <a href="{{ url('/login') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Login</a>
                        <a href="{{ url('/register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition">Register</a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-xl font-bold mb-4">HotelHub</h3>
                    <p class="text-gray-400">Your trusted partner for comfortable and luxurious hotel bookings. Experience hospitality at its finest.</p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white transition">About Us</a></li>
                        <li><a href="{{ route('services') }}" class="text-gray-400 hover:text-white transition">Services</a></li>
                        <li><a href="{{ route('blogs.index') }}" class="text-gray-400 hover:text-white transition">Blogs</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white transition">Contact</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Services</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Hotel Booking</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Room Reservation</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Travel Packages</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Corporate Events</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact Us</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>📍 123 Hotel Street, City</li>
                        <li>📞 +1 234 567 890</li>
                        <li>✉️ info@hotelhub.com</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} HotelHub. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
