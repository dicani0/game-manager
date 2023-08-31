<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'available_promotes' => 1000,
            'private' => false,
            'discord_name' => 'Admin',
        ])->assignRole('admin');

        User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'available_promotes' => 1000,
            'private' => false,
            'discord_name' => 'User',
        ])->assignRole('user');
    }
}
