<?php

namespace Tests\Feature;

use App\Models\Cosmetics\Cosmetic;
use App\Models\User;
use Tests\TestCase;

class MarketTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_create_market_offer(): void
    {
        $cosmetic1 = Cosmetic::factory()->create();
        $cosmetic2 = Cosmetic::factory()->create();
        $cosmetic3 = Cosmetic::factory()->create();

        $this->user->cosmetics()->saveMany([$cosmetic1, $cosmetic2, $cosmetic3]);

        $this->actingAs($this->user)->post('/market', [
            'items' => [
                [
                    'cosmetic_id' => $cosmetic1->getKey(),
                    'amount' => 1,
                ],
                [
                    'cosmetic_id' => $cosmetic2->getKey(),
                    'amount' => 1,
                ],
                [
                    'cosmetic_id' => $cosmetic3->getKey(),
                    'amount' => 1,
                ],
            ],
        ]);

        $this->assertDatabaseHas('market_offers', [
            'user_id' => $this->user->getKey(),
            'promoted' => false,
        ]);

        $this->assertDatabaseHas('market_offer_items', [
            'cosmetic_id' => $cosmetic1->getKey(),
            'amount' => 1,
        ]);

        $this->assertDatabaseHas('market_offer_items', [
            'cosmetic_id' => $cosmetic2->getKey(),
            'amount' => 1,
        ]);

        $this->assertDatabaseHas('market_offer_items', [
            'cosmetic_id' => $cosmetic3->getKey(),
            'amount' => 1,
        ]);
    }
}
