<?php

namespace Tests\Feature;

use App\Enums\MarketOfferRequestStatusEnum;
use App\Enums\MarketOfferStatusEnum;
use App\Enums\OfferTypeEnum;
use App\Models\Cosmetics\Cosmetic;
use App\Models\Cosmetics\UserCosmetic;
use App\Models\Market\MarketOffer;
use App\Models\Market\OfferRequest;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
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

    public function test_user_market_offers()
    {
        $offer = MarketOffer::factory()->create([
            'user_id' => $this->user->getKey(),
        ]);

        $user2 = User::factory()->create();

        $offer2 = MarketOffer::factory()->create([
            'user_id' => $user2->getKey(),
        ]);

        $this->actingAs($this->user)->get('/market/my')
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->component('Market/MyOffers')
                ->has('offers.data', 1, fn(AssertableInertia $page) => $page
                    ->where('id', $offer->getKey())
                    ->etc()
                ));

        $this->actingAs($this->user)->get('/market')
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->component('Market/Market')
                ->has('offers.data', 1, fn(AssertableInertia $page) => $page
                    ->where('id', $offer2->getKey())
                    ->etc()
                ));

    }

    public function test_accept_trade_request()
    {
        $buyer = User::factory()->create();

        $cosmetic1 = Cosmetic::factory()->create(['name' => 'abc']);
        $cosmetic2 = Cosmetic::factory()->create(['name' => 'def']);
        $cosmetic3 = Cosmetic::factory()->create(['name' => 'ghi']);

        $this->user->cosmetics()->detach();

        $this->user->cosmetics()->attach([
            $cosmetic1->getKey() => [
                'amount' => 5,
                'reserved_amount' => 5,
            ],
            $cosmetic2->getKey() => [
                'amount' => 5,
                'reserved_amount' => 3,
            ],
            $cosmetic3->getKey() => [
                'amount' => 5,
                'reserved_amount' => 1,
            ],
        ]);

        $offer = MarketOffer::factory()->create([
            'user_id' => $this->user->getKey(),
        ]);

        $offer->items()->createMany([
            [
                'cosmetic_id' => $cosmetic1->getKey(),
                'amount' => 5,
            ],
            [
                'cosmetic_id' => $cosmetic2->getKey(),
                'amount' => 3,
            ],
            [
                'cosmetic_id' => $cosmetic3->getKey(),
                'amount' => 1,
            ],
        ]);

        $offerRequest = OfferRequest::create([
            'user_id' => $buyer->getKey(),
            'offerable_id' => $offer->getKey(),
            'offerable_type' => MarketOffer::class,
            'type' => OfferTypeEnum::BUY->value,
            'status' => MarketOfferRequestStatusEnum::PENDING->value,
        ]);

        $offerRequest->cosmetics()->attach([
            $cosmetic1->getKey() => [
                'amount' => 3,
            ],
            $cosmetic2->getKey() => [
                'amount' => 3,
            ],
            $cosmetic3->getKey() => [
                'amount' => 1,
            ],
        ]);

        $res = $this->actingAs($this->user)->post("/market/{$offer->getKey()}/{$offerRequest->getKey()}/accept");
//        dd($res->json());
        dd($this->user->refresh()->cosmetics->toArray());
    }
}
