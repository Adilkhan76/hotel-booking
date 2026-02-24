<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('room')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('bookings.index', compact('bookings'));
    }

    public function store(Request $request)
{
    $request->validate([
        'room_id' => 'required',
        'check_in' => 'required|date',
        'check_out' => 'required|date|after:check_in'
    ]);

    $exists = Booking::where('room_id', $request->room_id)
        ->where(function($query) use ($request) {
            $query->whereBetween('check_in', [$request->check_in, $request->check_out])
                  ->orWhereBetween('check_out', [$request->check_in, $request->check_out]);
        })->exists();

    if ($exists) {
        return back()->with('error','Room already booked for selected dates.');
    }

    $room = Room::findOrFail($request->room_id);
    $days = Carbon::parse($request->check_in)
        ->diffInDays(Carbon::parse($request->check_out));

    $total = $days * $room->price_per_night;

    Booking::create([
        'user_id' => Auth::id(),
        'room_id' => $room->id,
        'check_in' => $request->check_in,
        'check_out' => $request->check_out,
        'total_price' => $total,
        'status' => 'booked'
    ]);

    return redirect()->route('dashboard')->with('success', 'Room booked successfully!');
}

    // Admin methods for booking management
    public function adminIndex()
    {
        $bookings = Booking::with(['user', 'room.hotel'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function adminUpdate(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:booked,cancelled,successful'
        ]);

        $booking->update([
            'status' => $request->status
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking status updated successfully!');
    }

    public function adminDestroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully!');
    }
}
