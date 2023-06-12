<?php

namespace Database\Seeders;

use App\Models\Cosmetics\Cosmetic;
use Illuminate\Database\Seeder;

class CosmeticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cosmetic::factory()->count(60)->create();
    }
}
