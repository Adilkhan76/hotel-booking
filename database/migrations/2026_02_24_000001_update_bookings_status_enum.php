<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, modify the column to VARCHAR to handle the transition
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status VARCHAR(20) DEFAULT 'booked'");
        
        // Now update existing values
        DB::table('bookings')->where('status', 'confirmed')->update(['status' => 'booked']);
        
        // Now set it back to ENUM with new values
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('booked', 'cancelled', 'successful') DEFAULT 'booked'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Change back from new statuses to 'confirmed'
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status VARCHAR(20) DEFAULT 'confirmed'");
        
        DB::table('bookings')->whereIn('status', ['booked', 'successful'])->update(['status' => 'confirmed']);
        
        // Revert to original enum
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('confirmed', 'cancelled') DEFAULT 'confirmed'");
    }
};
