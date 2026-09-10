<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'pramudyasatria@gmail.com',
            'phone' => '08123456789',
            'password_hash' => bcrypt('admin123'),
            'account_status' => 'active',
            'last_login_at' => now(),
        ]);
    }
}
