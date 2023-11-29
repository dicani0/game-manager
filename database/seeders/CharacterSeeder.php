<?php

namespace Database\Seeders;

use App\Models\Character\Character;
use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws Exception
     */
    public function run(): void
    {
        $admin = User::query()->where('email', 'admin@example.com')->first();

        Character::factory()->count(20)->create([
            'user_id' => $admin->getKey(),
        ]);
    }
}
