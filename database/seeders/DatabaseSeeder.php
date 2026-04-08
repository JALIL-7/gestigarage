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
        if (! User::where('email', 'admin@gestigarage.com')->exists()) {
            User::factory()->create([
                'name' => 'Admin Garage',
                'email' => 'admin@gestigarage.com',
                'password' => bcrypt('password'),
            ]);
        }
    }
}
