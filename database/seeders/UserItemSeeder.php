<?php

namespace Database\Seeders;

use App\Models\Items\Item;
use App\Models\User;
use Exception;
use Illuminate\Database\Seeder;

class UserItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws Exception
     */
    public function run(): void
    {
        $admin = User::query()->where('email', 'admin@example.com')->first();
        $user = User::query()->where('email', 'user@example.com')->first();

        $users = collect([$admin, $user]);

        $users->each(function (User $user) {
            $items = Item::all()->random(random_int(10, 20));
            $items = $items->mapWithKeys(function (Item $item) {
                return [$item->getKey() => ['amount' => random_int(1, 10)]];
            });
            $user->items()->attach($items);
        });
    }
}
