<?php

namespace Database\Seeders;

use App\Models\Items\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::factory()->count(60)->create();
    }
}
