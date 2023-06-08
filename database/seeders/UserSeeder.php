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
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'available_promotes' => 1000,
        ])->assignRole('admin');
    }
}
