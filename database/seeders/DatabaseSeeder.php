<?php

declare(strict_types=1);

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
        User::factory()->create([
            'name' => 'Admin',
            'lastname' => 'User',
            'email' => env('ADMIN_EMAIL'),
            'phone' => '1234567890',
            'birthdate' => '1990-01-01',
            'role' => 'admin',
            'password' => bcrypt(env('ADMIN_PASSWORD')),
        ]);
    }
}
