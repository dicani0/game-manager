<?php

namespace Tests\Feature;

use App\Enums\MarketOfferStatusEnum;
use App\Models\Cosmetics\Cosmetic;
use App\Models\Cosmetics\UserCosmetic;
use App\Models\Market\MarketOffer;
use App\Models\User;
use Tests\TestCase;

class MarketTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

        $this->cosmetic1 = Cosmetic::factory()->create();
        $this->cosmetic2 = Cosmetic::factory()->create();
        $this->cosmetic3 = Cosmetic::factory()->create();

        $this->cosmetics = collect([
            [
                'cosmetic_id' => $this->cosmetic1->getKey(),
                'amount' => 1,
            ],
            [
                'cosmetic_id' => $this->cosmetic2->getKey(),
                'amount' => 1,
            ],
            [
                'cosmetic_id' => $this->cosmetic3->getKey(),
                'amount' => 1,
            ],
        ]);

        $this->user->cosmetics()->attach($this->cosmetics);
    }

    /**
     * A basic feature test example.
     */
    public function test_create_market_offer(): void
    {
        $this->actingAs($this->user)->post('/market', [
            'items' => [
                [
                    'cosmetic_id' => $this->cosmetic1->getKey(),
                    'amount' => 1,
                ],
                [
                    'cosmetic_id' => $this->cosmetic2->getKey(),
                    'amount' => 1,
                ],
                [
                    'cosmetic_id' => $this->cosmetic3->getKey(),
                    'amount' => 1,
                ],
            ],
        ]);

        $this->assertDatabaseHas('market_offers', [
            'user_id' => $this->user->getKey(),
            'promoted' => false,
        ]);

        $this->assertDatabaseHas('market_offer_items', [
            'cosmetic_id' => $this->cosmetic1->getKey(),
            'amount' => 1,
        ]);

        $this->assertDatabaseHas('market_offer_items', [
            'cosmetic_id' => $this->cosmetic2->getKey(),
            'amount' => 1,
        ]);

        $this->assertDatabaseHas('market_offer_items', [
            'cosmetic_id' => $this->cosmetic3->getKey(),
            'amount' => 1,
        ]);

        $this->assertDatabaseHas('user_cosmetic', [
            'user_id' => $this->user->getKey(),
            'cosmetic_id' => $this->cosmetic1->getKey(),
            'amount' => 1,
            'used_amount' => 0,
            'sold_amount' => 0,
            'reserved_amount' => 1,
        ]);

        $this->assertDatabaseHas('user_cosmetic', [
            'user_id' => $this->user->getKey(),
            'cosmetic_id' => $this->cosmetic2->getKey(),
            'amount' => 1,
            'used_amount' => 0,
            'sold_amount' => 0,
            'reserved_amount' => 1,
        ]);

        $this->assertDatabaseHas('user_cosmetic', [
            'user_id' => $this->user->getKey(),
            'cosmetic_id' => $this->cosmetic3->getKey(),
            'amount' => 1,
            'used_amount' => 0,
            'sold_amount' => 0,
            'reserved_amount' => 1,
        ]);
    }

    public function test_cancel_market_offer()
    {
        $offer = MarketOffer::factory()->create([
            'user_id' => $this->user->getKey(),
        ]);

        UserCosmetic::query()->update([
            'reserved_amount' => 1,
        ]);

        $offer->items()->createMany($this->cosmetics->map(function ($cosmetic) {
            return [
                'cosmetic_id' => $cosmetic['cosmetic_id'],
                'amount' => $cosmetic['amount'],
            ];
        }));

        $this->actingAs($this->user)->delete('/market/' . $offer->getKey());

        $this->assertDatabaseHas('market_offers', [
            'id' => $offer->getKey(),
            'user_id' => $this->user->getKey(),
            'status' => MarketOfferStatusEnum::CANCELED->value,
        ]);

        $this->assertDatabaseHas('user_cosmetic', [
            'user_id' => $this->user->getKey(),
            'cosmetic_id' => $this->cosmetic1->getKey(),
            'amount' => 1,
            'used_amount' => 0,
            'sold_amount' => 0,
            'reserved_amount' => 0,
        ]);
    }
}
