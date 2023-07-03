<?php

namespace Database\Seeders;

use App\Models\Items\Item;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserCosmeticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->where('email', 'admin@example.com')->first();
        $items = Item::all()->random(30);
        $items = $items->mapWithKeys(function (Item $item) {
            return [$item->getKey() => ['amount' => random_int(1, 10)]];
        });

        $user->items()->attach($items);
    }
}
