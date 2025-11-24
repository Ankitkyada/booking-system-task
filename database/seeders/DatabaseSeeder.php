<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Bookings;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create one user
        $user = User::factory()->create();

        // Create one booking for this user
        Bookings::factory()->create([
            'user_id' => $user->id,
            'customer_name' => 'John Doe',
            'customer_email' => 'john.doe@example.com',
        ]);

        // Optional: multiple users with bookings
        User::factory(5)->create()->each(function ($user) {
            Bookings::factory(2)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
