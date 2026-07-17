<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create an admin user for Filament login
        User::factory()->create([
            'name' => 'فايز الزهراني',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // Call the BookSeeder
        $this->call(BookSeeder::class);
    }
}
