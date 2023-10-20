<?php


use App\Enums\MarketOfferRequestStatusEnum;
use App\Enums\OfferTypeEnum;
use App\Models\Items\Item;
use App\Models\Market\TradeOffer;
use App\Models\User;
use Tests\TestCase;

class TradeTest extends TestCase
{
    private User $seller;
    private User $buyer;

    private Item $item1;
    private Item $item2;
    private Item $item3;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seller = User::factory()->create();
        $this->buyer = User::factory()->create();

        $this->item1 = Item::factory()->create();
        $this->item2 = Item::factory()->create();
        $this->item3 = Item::factory()->create();

        $this->seller->items()->attach([
            [
                'item_id' => $this->item1->getKey(),
                'amount' => 3,
            ],
            [
                'item_id' => $this->item2->getKey(),
                'amount' => 3,
            ],
            [
                'item_id' => $this->item3->getKey(),
                'amount' => 3,
            ],
        ]);
    }

    public function test_create_user_offer(): void
    {

        $this->actingAs($this->buyer)->post("/market/user/{$this->seller->getKey()}/buy", [
            'lat_price' => 1,
            'at_price' => 1,
            'items' => [
                [
                    'id' => $this->item1->getKey(),
                    'amount' => 1,
                ],
                [
                    'id' => $this->item2->getKey(),
                    'amount' => 1,
                ],
                [
                    'id' => $this->item3->getKey(),
                    'amount' => 1,
                ],
            ],
        ]);

        $this->assertDatabaseHas('trade_offers', [
            'offerable_type' => User::class,
            'offerable_id' => $this->seller->getKey(),
            'user_id' => $this->buyer->getKey(),
            'lat_price' => 1,
            'at_price' => 1,
            'status' => MarketOfferRequestStatusEnum::PENDING->value,
            'type' => OfferTypeEnum::BUY->value,
        ]);

        $tradeOffer = TradeOffer::query()->first();

        $this->assertDatabaseHas('trade_offer_item', [
            'trade_offer_id' => $tradeOffer->getKey(),
            'item_id' => $this->item1->getKey(),
            'amount' => 1,
        ]);

        $this->assertDatabaseHas('trade_offer_item', [
            'trade_offer_id' => $tradeOffer->getKey(),
            'item_id' => $this->item2->getKey(),
            'amount' => 1,
        ]);

        $this->assertDatabaseHas('trade_offer_item', [
            'trade_offer_id' => $tradeOffer->getKey(),
            'item_id' => $this->item3->getKey(),
            'amount' => 1,
        ]);
    }

    public function test_create_user_offer_not_enough_items(): void
    {
        $this->actingAs($this->buyer)->post("/market/user/{$this->seller->getKey()}/buy", [
            'lat_price' => 1,
            'at_price' => 1,
            'items' => [
                [
                    'id' => $this->item1->getKey(),
                    'amount' => 5,
                ],
            ],
        ]);
        $this->assertEquals(session('errors')->getBag('default')->first(), 'User does not have enough items.');

        $this->assertDatabaseMissing('trade_offers', [
            'offerable_type' => User::class,
            'offerable_id' => $this->seller->getKey(),
            'user_id' => $this->buyer->getKey(),
            'lat_price' => 1,
            'at_price' => 1,
            'status' => MarketOfferRequestStatusEnum::PENDING->value,
            'type' => OfferTypeEnum::BUY->value,
        ]);
    }
}
