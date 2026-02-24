@extends('layouts.common')

@section('title', 'Available Rooms - HotelHub')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Available Rooms</h1>
            <p class="text-indigo-100">Choose from our selection of comfortable rooms</p>
        </div>
    </div>
</section>

<!-- Rooms Section -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if($rooms->isEmpty())
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <p class="text-gray-500">No rooms available at the moment.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($rooms as $room)
                    <div class="bg-white shadow-lg rounded-xl overflow-hidden hover:shadow-xl transition duration-300">
                        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-4">
                            <div class="flex justify-between items-center">
                                <span class="text-white font-bold text-xl">Room {{ $room->room_number }}</span>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                    {{ $room->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($room->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $room->room_type }}
                                </span>
                                <span class="text-gray-500 text-sm">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $room->capacity }} Guests
                                </span>
                            </div>
                            <p class="text-gray-600 mb-4">{{ $room->description }}</p>
                            <div class="flex justify-between items-center border-t pt-4">
                                <div>
                                    <span class="text-2xl font-bold text-indigo-600">${{ number_format($room->price_per_night, 2) }}</span>
                                    <span class="text-gray-500 text-sm">/night</span>
                                </div>
                                @auth
                                    @if($room->status === 'available')
                                        <button onclick="openBookingModal({{ $room->id }}, '{{ $room->room_number }}', {{ $room->price_per_night }})" 
                                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition">
                                            Book Now
                                        </button>
                                    @else
                                        <span class="text-gray-400 text-sm">Not Available</span>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium transition">
                                        Login to Book
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- Booking Modal -->
<div id="bookingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">Book Room <span id="modalRoomNumber"></span></h3>
                <button onclick="closeBookingModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="bookingForm" action="{{ route('bookings.store') }}" method="POST">
                @csrf
                <input type="hidden" name="room_id" id="roomId">
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price per Night</label>
                    <div class="text-lg font-semibold text-indigo-600">$<span id="modalPrice"></span></div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Check-in Date</label>
                    <input type="date" name="check_in" id="checkIn" required min="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Check-out Date</label>
                    <input type="date" name="check_out" id="checkOut" required min="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Total Price</label>
                    <div class="text-xl font-bold text-gray-900">$<span id="totalPrice">0.00</span></div>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="closeBookingModal()" 
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-4 rounded-lg font-medium transition">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg font-medium transition">
                        Confirm Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openBookingModal(roomId, roomNumber, price) {
        document.getElementById('roomId').value = roomId;
        document.getElementById('modalRoomNumber').textContent = roomNumber;
        document.getElementById('modalPrice').textContent = price.toFixed(2);
        document.getElementById('bookingModal').classList.remove('hidden');
    }

    function closeBookingModal() {
        document.getElementById('bookingModal').classList.add('hidden');
    }

    // Calculate total price when dates change
    document.getElementById('checkOut').addEventListener('change', function() {
        const checkIn = new Date(document.getElementById('checkIn').value);
        const checkOut = new Date(this.value);
        const price = parseFloat(document.getElementById('modalPrice').textContent);
        
        if (checkIn && checkOut && checkOut > checkIn) {
            const days = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
            const total = days * price;
            document.getElementById('totalPrice').textContent = total.toFixed(2);
        }
    });

    document.getElementById('checkIn').addEventListener('change', function() {
        const checkIn = new Date(this.value);
        const checkOut = new Date(document.getElementById('checkOut').value);
        const price = parseFloat(document.getElementById('modalPrice').textContent);
        
        if (checkIn && checkOut && checkOut > checkIn) {
            const days = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
            const total = days * price;
            document.getElementById('totalPrice').textContent = total.toFixed(2);
        }
    });

    // Close modal when clicking outside
    document.getElementById('bookingModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeBookingModal();
        }
    });
</script>
@endsection
