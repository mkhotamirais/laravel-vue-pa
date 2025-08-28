<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::Create([
            'id' => 1,
            'name' => 'panoramaalam',
            'email' => 'panoramaalamofficial@gmail.com',
            'email_verified_at' => now(),
            'password' => 'Bismillah_2025!',
            // 'role' => 'admin',
            'remember_token' => null,
        ]);
    }
}
