<?php

namespace Database\Seeders;

use App\Models\Items\Item;
use Illuminate\Database\Seeder;

class CosmeticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::factory()->count(60)->create();
    }
}
