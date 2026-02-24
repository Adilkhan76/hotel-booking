<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Room;
use App\Models\Blog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users with different roles
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@hotelhub.com',
                'password' => bcrypt('admin123'),
                'role' => 'super_admin',
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@hotelhub.com',
                'password' => bcrypt('manager123'),
                'role' => 'manager',
            ],
            [
                'name' => 'Receptionist',
                'email' => 'receptionist@hotelhub.com',
                'password' => bcrypt('receptionist123'),
                'role' => 'receptionist',
            ],
            [
                'name' => 'Waiter',
                'email' => 'waiter@hotelhub.com',
                'password' => bcrypt('waiter123'),
                'role' => 'waiter',
            ],
            [
                'name' => 'Cook',
                'email' => 'cook@hotelhub.com',
                'password' => bcrypt('cook123'),
                'role' => 'cook',
            ],
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
                'role' => 'user',
            ],
        ];

        $adminUser = null;
        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
            if ($userData['role'] === 'super_admin') {
                $adminUser = $user;
            }
        }

        // Create rooms
        $rooms = [
            [
                'room_number' => '101',
                'room_type' => 'Standard',
                'price_per_night' => 100.00,
                'capacity' => 2,
                'description' => 'A comfortable standard room with essential amenities.',
                'status' => 'available',
            ],
            [
                'room_number' => '102',
                'room_type' => 'Standard',
                'price_per_night' => 100.00,
                'capacity' => 2,
                'description' => 'A comfortable standard room with essential amenities.',
                'status' => 'available',
            ],
            [
                'room_number' => '201',
                'room_type' => 'Deluxe',
                'price_per_night' => 150.00,
                'capacity' => 3,
                'description' => 'Spacious deluxe room with premium amenities.',
                'status' => 'available',
            ],
            [
                'room_number' => '202',
                'room_type' => 'Deluxe',
                'price_per_night' => 150.00,
                'capacity' => 3,
                'description' => 'Spacious deluxe room with premium amenities.',
                'status' => 'available',
            ],
            [
                'room_number' => '301',
                'room_type' => 'Suite',
                'price_per_night' => 250.00,
                'capacity' => 4,
                'description' => 'Luxurious suite with separate living area and premium facilities.',
                'status' => 'available',
            ],
        ];

        foreach ($rooms as $room) {
            Room::firstOrCreate(
                ['room_number' => $room['room_number']],
                $room
            );
        }

        // Create sample blog posts
        $blogs = [
            [
                'title' => '10 Tips for a Perfect Hotel Stay',
                'short_description' => 'Discover the top tips to make your hotel stay comfortable and enjoyable.',
                'content' => '<p>Staying at a hotel can be a wonderful experience if you know how to make the most of it. Here are our top 10 tips for a perfect hotel stay:</p><ol><li><strong>Book early</strong> - Secure the best rooms by booking in advance.</li><li><strong>Check reviews</strong> - Read reviews from previous guests to know what to expect.</li><li><strong>Pack smart</strong> - Bring essential items even if the hotel provides toiletries.</li><li><strong>Request amenities</strong> - Don\'t hesitate to ask for extra pillows or blankets.</li><li><strong>Use room service wisely</strong> - Know the menu and timing before ordering.</li><li><strong>Keep it secure</strong> - Use the room safe for valuables.</li><li><strong>Explore the hotel</strong> - Take advantage of hotel amenities like pool, gym, or spa.</li><li><strong>Communicate with staff</strong> - Hotel staff are there to help you have a great stay.</li><li><strong>Be flexible</strong> - Sometimes the best experiences come from unexpected changes.</li><li><strong>Leave a review</strong> - Share your experience to help other travelers.</li></ol>',
                'status' => 'published',
            ],
            [
                'title' => 'The Future of Hotel Technology',
                'short_description' => 'Explore how technology is revolutionizing the hospitality industry.',
                'content' => '<p>The hotel industry is undergoing a massive transformation thanks to technology. From smart rooms to contactless check-in, here\'s what the future holds:</p><h3>Smart Rooms</h3><p>Voice-controlled lighting, temperature, and entertainment systems are becoming standard in modern hotels.</p><h3>Contactless Services</h3><p>Mobile check-in, digital room keys, and touchless payments are now expected by guests.</p><h3>AI Personalization</h3><p>Hotels are using artificial intelligence to personalize guest experiences based on preferences and past stays.</p><h3>Robotics</h3><p>From robot concierge to automated housekeeping, robots are becoming part of the hotel staff.</p>',
                'status' => 'published',
            ],
            [
                'title' => 'Best Destinations for a Weekend Getaway',
                'short_description' => 'Looking for a quick escape? Here are the best destinations for a weekend trip.',
                'content' => '<p>A weekend getaway can be just what you need to recharge and refresh. Here are our top picks for short trips:</p><h3>1. Beach Resorts</h3><p>Nothing beats the relaxation of a beach getaway. Popular options include Miami, Malibu, and the Caribbean islands.</p><h3>2. Mountain Retreats</h3><p>Escape to the mountains for fresh air and adventure. Consider Aspen, Vermont, or the Swiss Alps.</p><h3>3. City Breaks</h3><p>New York, Paris, Tokyo - these cities offer endless entertainment and cultural experiences.</p><h3>4. Countryside Escapes</h3><p>For a peaceful retreat, consider bed and breakfasts in the countryside or wine country vacations.</p>',
                'status' => 'published',
            ],
        ];

        foreach ($blogs as $blogData) {
            $blogData['slug'] = Str::slug($blogData['title']);
            $blogData['user_id'] = $adminUser ? $adminUser->id : 1;
            $blogData['image'] = 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800';
            Blog::firstOrCreate(
                ['slug' => $blogData['slug']],
                $blogData
            );
        }
    }
}
