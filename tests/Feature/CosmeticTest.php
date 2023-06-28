<?php

namespace Tests\Feature;

use App\Models\Items\Item;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CosmeticTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_import(): void
    {
        Artisan::call('app:import-cosmetics-list');
        $this->assertNotEmpty(Item::all());
    }

    public function test_update_cosmetics_list(): void
    {
//        $userOne = User::factory()->create();
//        $userTwo = User::factory()->create();
//
//        $userOne->cosmetics()->attach(Item::factory()->create());
    }
}
