<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get time-based greeting
        $greeting = $this->getGreeting();
        
        // Role-based dashboard logic
        if ($user->role === 'super_admin') {
            return $this->adminDashboard();
        } elseif (in_array($user->role, ['manager', 'receptionist', 'waiter', 'cook'])) {
            return $this->employeeDashboard($user, $greeting);
        } else {
            return $this->userDashboard($user, $greeting);
        }
    }

    private function getGreeting()
    {
        $hour = now()->hour;
        $minute = now()->minute;
        $timeInMinutes = $hour * 60 + $minute;
        
        // Time-Based Greeting Logic (Mandatory)
        // 3:00 AM (180) – 11:50 AM (710): Good Morning
        // 11:51 AM (711) – 4:00 PM (960): Good Afternoon
        // 4:01 PM (961) – 7:00 PM (1260): Good Evening
        // 7:01 PM (1261) – 3:00 AM (180): Good Night
        
        if ($timeInMinutes >= 180 && $timeInMinutes <= 710) {
            return 'Good Morning';
        } elseif ($timeInMinutes >= 711 && $timeInMinutes <= 960) {
            return 'Good Afternoon';
        } elseif ($timeInMinutes >= 961 && $timeInMinutes <= 1260) {
            return 'Good Evening';
        } else {
            return 'Good Night';
        }
    }

    private function adminDashboard()
    {
        $totalHotels = Hotel::count();
        $totalUsers = User::count();
        $totalBookings = Booking::count();
        
        $bookedCount = Booking::where('status', 'booked')->count();
        $cancelledCount = Booking::where('status', 'cancelled')->count();
        $successfulCount = Booking::where('status', 'successful')->count();
        
        $recentBookings = Booking::with(['user', 'room.hotel'])->latest()->take(10)->get();
        $recentUsers = User::latest()->take(5)->get();
        
        return view('dashboard', compact(
            'totalHotels',
            'totalUsers',
            'totalBookings',
            'bookedCount',
            'cancelledCount',
            'successfulCount',
            'recentBookings',
            'recentUsers'
        ));
    }

    private function employeeDashboard($user, $greeting)
    {
        return view('dashboard', compact('user', 'greeting'));
    }

    private function userDashboard($user, $greeting)
    {
        $bookings = Booking::where('user_id', $user->id)
            ->with('room')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('dashboard', compact('user', 'greeting', 'bookings'));
    }
}
