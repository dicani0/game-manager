<?php

namespace Tests\Feature;

use App\Enums\MarketOfferRequestStatusEnum;
use App\Enums\MarketOfferStatusEnum;
use App\Enums\OfferTypeEnum;
use App\Events\Market\TradeOfferCreated;
use App\Jobs\Market\SetMarketOfferStatusAsExpired;
use App\Mail\MarketOfferExpired;
use App\Models\Items\Item;
use App\Models\Items\UserItem;
use App\Models\Market\MarketOffer;
use App\Models\Market\TradeOffer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class MarketTest extends TestCase
{
    private User $user;
    private Item $item1;
    private Item $item2;
    private Item $item3;
    private Collection $items;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

        $this->item1 = Item::factory()->create();
        $this->item2 = Item::factory()->create();
        $this->item3 = Item::factory()->create();

        $this->items = collect([
            [
                'item_id' => $this->item1->getKey(),
                'amount' => 1,
            ],
            [
                'item_id' => $this->item2->getKey(),
                'amount' => 1,
            ],
            [
                'item_id' => $this->item3->getKey(),
                'amount' => 1,
            ],
        ]);

        $this->user->items()->attach($this->items);
    }

    /**
     * A basic feature test example.
     */
    public function test_create_market_offer(): void
    {
        $this->actingAs($this->user)->post('/market', [
            'items' => [
                [
                    'item_id' => $this->item1->getKey(),
                    'amount' => 1,
                ],
                [
                    'item_id' => $this->item2->getKey(),
                    'amount' => 1,
                ],
                [
                    'item_id' => $this->item3->getKey(),
                    'amount' => 1,
                ],
            ],
        ]);

        $this->assertDatabaseHas('market_offers', [
            'user_id' => $this->user->getKey(),
            'promoted' => false,
        ]);

        $this->assertDatabaseHas('market_offer_items', [
            'item_id' => $this->item1->getKey(),
            'amount' => 1,
        ]);

        $this->assertDatabaseHas('market_offer_items', [
            'item_id' => $this->item2->getKey(),
            'amount' => 1,
        ]);

        $this->assertDatabaseHas('market_offer_items', [
            'item_id' => $this->item3->getKey(),
            'amount' => 1,
        ]);

        $this->assertDatabaseHas('user_item', [
            'user_id' => $this->user->getKey(),
            'item_id' => $this->item1->getKey(),
            'amount' => 1,
            'used_amount' => 0,
            'sold_amount' => 0,
            'reserved_amount' => 1,
        ]);

        $this->assertDatabaseHas('user_item', [
            'user_id' => $this->user->getKey(),
            'item_id' => $this->item2->getKey(),
            'amount' => 1,
            'used_amount' => 0,
            'sold_amount' => 0,
            'reserved_amount' => 1,
        ]);

        $this->assertDatabaseHas('user_item', [
            'user_id' => $this->user->getKey(),
            'item_id' => $this->item3->getKey(),
            'amount' => 1,
            'used_amount' => 0,
            'sold_amount' => 0,
            'reserved_amount' => 1,
        ]);
    }

    public function test_create_buy_offer(): void
    {
        Event::fake();
        $buyer = User::factory()->create();

        $marketOffer = MarketOffer::factory()->create([
            'user_id' => $this->user->getKey(),
        ]);

        $this->actingAs($buyer)->post('market/' . $marketOffer->getKey() . '/buy', [
            'lat_price' => 0,
            'at_price' => 0,
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
            'offerable_type' => MarketOffer::class,
            'user_id' => $buyer->getKey(),
            'at_price' => 0,
            'lat_price' => 0,
            'type' => OfferTypeEnum::BUY->value,
            'status' => MarketOfferRequestStatusEnum::PENDING->value,
        ]);

        Event::assertDispatched(TradeOfferCreated::class);
    }

    public function test_cancel_market_offer()
    {
        $offer = MarketOffer::factory()->create([
            'user_id' => $this->user->getKey(),
        ]);

        UserItem::query()->update([
            'reserved_amount' => 1,
        ]);

        $offer->items()->createMany($this->items->map(function ($item) {
            return [
                'item_id' => $item['item_id'],
                'amount' => $item['amount'],
            ];
        }));

        $this->actingAs($this->user)->delete('/market/' . $offer->getKey());

        $this->assertDatabaseHas('market_offers', [
            'id' => $offer->getKey(),
            'user_id' => $this->user->getKey(),
            'status' => MarketOfferStatusEnum::CANCELED->value,
        ]);

        $this->assertDatabaseHas('user_item', [
            'user_id' => $this->user->getKey(),
            'item_id' => $this->item1->getKey(),
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
            ->assertInertia(
                fn(AssertableInertia $page) => $page
                    ->component('Market/MyOffers')
                    ->has(
                        'offers.data',
                        1,
                        fn(AssertableInertia $page) => $page
                            ->where('id', $offer->getKey())
                            ->etc()
                    )
            );

        $this->actingAs($this->user)->get('/market')
            ->assertInertia(
                fn(AssertableInertia $page) => $page
                    ->component('Market/Market')
                    ->has(
                        'offers.data',
                        1,
                        fn(AssertableInertia $page) => $page
                            ->where('id', $offer2->getKey())
                            ->etc()
                    )
            );

    }

    public function test_accept_trade_request_unauthorized()
    {
        $buyer = User::factory()->create();
        $buyer2 = User::factory()->create();

        $item1 = Item::factory()->create(['name' => 'abc']);
        $item2 = Item::factory()->create(['name' => 'def']);
        $item3 = Item::factory()->create(['name' => 'ghi']);

        $this->user->items()->detach();

        $this->user->items()->attach([
            $item1->getKey() => [
                'amount' => 5,
                'reserved_amount' => 5,
            ],
            $item2->getKey() => [
                'amount' => 5,
                'reserved_amount' => 3,
            ],
            $item3->getKey() => [
                'amount' => 5,
                'reserved_amount' => 1,
            ],
        ]);

        $offer = MarketOffer::factory()->create([
            'user_id' => $this->user->getKey(),
        ]);

        $offer->items()->createMany([
            [
                'item_id' => $item1->getKey(),
                'amount' => 5,
            ],
            [
                'item_id' => $item2->getKey(),
                'amount' => 3,
            ],
            [
                'item_id' => $item3->getKey(),
                'amount' => 1,
            ],
        ]);

        $tradeOffer = TradeOffer::create([
            'user_id' => $buyer->getKey(),
            'offerable_id' => $offer->getKey(),
            'offerable_type' => MarketOffer::class,
            'type' => OfferTypeEnum::BUY->value,
            'status' => MarketOfferRequestStatusEnum::PENDING->value,
        ]);

        $tradeOffer->items()->attach([
            $item1->getKey() => [
                'amount' => 3,
            ],
            $item2->getKey() => [
                'amount' => 3,
            ],
            $item3->getKey() => [
                'amount' => 1,
            ],
        ]);

        $this
            ->actingAs($buyer2)
            ->post("/market/{$tradeOffer->getKey()}/{$offer->getKey()}/accept")
            ->assertRedirect();

        $this->assertEquals(session('errors')->getBag('default')->first(), 'This action is unauthorized.');

        $this->assertDatabaseHas('trade_offers', [
            'id' => $tradeOffer->getKey(),
            'status' => MarketOfferRequestStatusEnum::PENDING->value,
        ]);
    }

    public function test_accept_trade_request_ok()
    {
        $buyer = User::factory()->create();
        $buyer2 = User::factory()->create();

        $item1 = Item::factory()->create(['name' => 'abc']);
        $item2 = Item::factory()->create(['name' => 'def']);
        $item3 = Item::factory()->create(['name' => 'ghi']);

        $this->user->items()->detach();

        $this->user->items()->attach([
            $item1->getKey() => [
                'amount' => 5,
                'reserved_amount' => 5,
            ],
            $item2->getKey() => [
                'amount' => 5,
                'reserved_amount' => 3,
            ],
            $item3->getKey() => [
                'amount' => 5,
                'reserved_amount' => 1,
            ],
        ]);

        $offer = MarketOffer::factory()->create([
            'user_id' => $this->user->getKey(),
        ]);

        $offer->items()->createMany([
            [
                'item_id' => $item1->getKey(),
                'amount' => 5,
            ],
            [
                'item_id' => $item2->getKey(),
                'amount' => 3,
            ],
            [
                'item_id' => $item3->getKey(),
                'amount' => 1,
            ],
        ]);

        $tradeOffer = TradeOffer::create([
            'user_id' => $buyer->getKey(),
            'offerable_id' => $offer->getKey(),
            'offerable_type' => MarketOffer::class,
            'type' => OfferTypeEnum::BUY->value,
            'status' => MarketOfferRequestStatusEnum::PENDING->value,
        ]);

        $tradeOffer->items()->attach([
            $item1->getKey() => [
                'amount' => 3,
            ],
            $item2->getKey() => [
                'amount' => 3,
            ],
            $item3->getKey() => [
                'amount' => 1,
            ],
        ]);

        $tradeOffer2 = TradeOffer::create([
            'user_id' => $buyer2->getKey(),
            'offerable_id' => $offer->getKey(),
            'offerable_type' => MarketOffer::class,
            'type' => OfferTypeEnum::BUY->value,
            'status' => MarketOfferRequestStatusEnum::PENDING->value,
            'at_price' => 100,
            'lat_price' => 100,
        ]);

        $tradeOffer2->items()->attach([
            $item1->getKey() => [
                'amount' => 3,
            ],
            $item2->getKey() => [
                'amount' => 2,
            ],
            $item3->getKey() => [
                'amount' => 1,
            ],
        ]);

        $tradeOffer3 = TradeOffer::create([
            'user_id' => $buyer2->getKey(),
            'offerable_id' => $offer->getKey(),
            'offerable_type' => MarketOffer::class,
            'type' => OfferTypeEnum::BUY->value,
            'status' => MarketOfferRequestStatusEnum::PENDING->value,
            'at_price' => 100,
            'lat_price' => 100,
        ]);

        $tradeOffer3->items()->attach([
            $item1->getKey() => [
                'amount' => 2,
            ],
            $item2->getKey() => [
                'amount' => 2,
            ],
            $item3->getKey() => [
                'amount' => 1,
            ],
        ]);

        $this->actingAs($this->user)->post("/market/{$tradeOffer->getKey()}/{$offer->getKey()}/accept");

        $this->assertDatabaseHas('user_item', [
            'user_id' => $buyer->getKey(),
            'item_id' => $item1->getKey(),
            'bought_amount' => 3,
        ]);

        $this->assertDatabaseHas('user_item', [
            'user_id' => $buyer->getKey(),
            'item_id' => $item2->getKey(),
            'bought_amount' => 3,
        ]);

        $this->assertDatabaseHas('user_item', [
            'user_id' => $buyer->getKey(),
            'item_id' => $item3->getKey(),
            'bought_amount' => 1,
        ]);

        $this->assertDatabaseHas('market_offers', [
            'id' => $offer->getKey(),
            'user_id' => $this->user->getKey(),
            'status' => MarketOfferStatusEnum::ACTIVE->value,
        ]);

        $this->assertDatabaseHas('trade_offers', [
            'id' => $tradeOffer->getKey(),
            'user_id' => $buyer->getKey(),
            'status' => MarketOfferRequestStatusEnum::ACCEPTED->value,
        ]);

        $this->assertDatabaseHas('trade_offers', [
            'id' => $tradeOffer2->getKey(),
            'user_id' => $buyer2->getKey(),
            'status' => MarketOfferRequestStatusEnum::REJECTED->value,
        ]);

        $this->assertDatabaseHas('trade_offers', [
            'id' => $tradeOffer3->getKey(),
            'user_id' => $buyer2->getKey(),
            'status' => MarketOfferRequestStatusEnum::PENDING->value,
        ]);

        $this->assertDatabaseHas('user_item', [
            'user_id' => $this->user->getKey(),
            'item_id' => $item1->getKey(),
            'amount' => 5,
            'used_amount' => 0,
            'sold_amount' => 3,
            'reserved_amount' => 2,
        ]);

        $this->assertDatabaseHas('user_item', [
            'user_id' => $this->user->getKey(),
            'item_id' => $item2->getKey(),
            'amount' => 5,
            'used_amount' => 0,
            'sold_amount' => 3,
            'reserved_amount' => 0,
        ]);

        $this->assertDatabaseHas('user_item', [
            'user_id' => $this->user->getKey(),
            'item_id' => $item3->getKey(),
            'amount' => 5,
            'used_amount' => 0,
            'sold_amount' => 1,
            'reserved_amount' => 0,
        ]);

        $tradeOffer4 = TradeOffer::create([
            'user_id' => $buyer2->getKey(),
            'offerable_id' => $offer->getKey(),
            'offerable_type' => MarketOffer::class,
            'type' => OfferTypeEnum::BUY->value,
            'status' => MarketOfferRequestStatusEnum::PENDING->value,
            'at_price' => 100,
            'lat_price' => 100,
        ]);

        $tradeOffer4->items()->attach([
            $item1->getKey() => [
                'amount' => 2,
            ],
        ]);

        $res = $this->actingAs($this->user)->post("/market/{$tradeOffer4->getKey()}/{$offer->getKey()}/accept");

        $this->assertDatabaseHas('trade_offers', [
            'id' => $tradeOffer4->getKey(),
            'user_id' => $buyer2->getKey(),
            'status' => MarketOfferRequestStatusEnum::ACCEPTED->value,
        ]);

        $this->assertDatabaseHas('user_item', [
            'user_id' => $this->user->getKey(),
            'item_id' => $item1->getKey(),
            'amount' => 5,
            'used_amount' => 0,
            'sold_amount' => 5,
            'reserved_amount' => 0,
        ]);

        $this->assertDatabaseHas('market_offers', [
            'id' => $offer->getKey(),
            'user_id' => $this->user->getKey(),
            'status' => MarketOfferStatusEnum::FINISHED->value,
        ]);
    }

    public function test_reject_trade_request_unauthorized()
    {
        $buyer = User::factory()->create();

        $item1 = Item::factory()->create(['name' => 'abc']);
        $item2 = Item::factory()->create(['name' => 'def']);
        $item3 = Item::factory()->create(['name' => 'ghi']);

        $this->user->items()->detach();

        $this->user->items()->attach([
            $item1->getKey() => [
                'amount' => 5,
                'reserved_amount' => 5,
            ],
            $item2->getKey() => [
                'amount' => 5,
                'reserved_amount' => 3,
            ],
            $item3->getKey() => [
                'amount' => 5,
                'reserved_amount' => 1,
            ],
        ]);

        $offer = MarketOffer::factory()->create([
            'user_id' => $this->user->getKey(),
        ]);

        $offer->items()->createMany([
            [
                'item_id' => $item1->getKey(),
                'amount' => 5,
            ],
            [
                'item_id' => $item2->getKey(),
                'amount' => 3,
            ],
            [
                'item_id' => $item3->getKey(),
                'amount' => 1,
            ],
        ]);

        $tradeOffer = TradeOffer::create([
            'user_id' => $buyer->getKey(),
            'offerable_id' => $offer->getKey(),
            'offerable_type' => MarketOffer::class,
            'type' => OfferTypeEnum::BUY->value,
            'status' => MarketOfferRequestStatusEnum::PENDING->value,
        ]);

        $tradeOffer->items()->attach([
            $item1->getKey() => [
                'amount' => 3,
            ],
            $item2->getKey() => [
                'amount' => 3,
            ],
            $item3->getKey() => [
                'amount' => 1,
            ],
        ]);

        $this
            ->actingAs($buyer)
            ->post("/market/{$tradeOffer->getKey()}/{$offer->getKey()}/reject")
            ->assertRedirect();


        $this->assertEquals(session('errors')->getBag('default')->first(), 'This action is unauthorized.');

        $this->assertDatabaseHas('trade_offers', [
            'id' => $tradeOffer->getKey(),
            'status' => MarketOfferRequestStatusEnum::PENDING->value,
        ]);
    }

    public function test_reject_trade_request_ok()
    {
        $buyer = User::factory()->create();

        $item1 = Item::factory()->create(['name' => 'abc']);
        $item2 = Item::factory()->create(['name' => 'def']);
        $item3 = Item::factory()->create(['name' => 'ghi']);

        $this->user->items()->detach();

        $this->user->items()->attach([
            $item1->getKey() => [
                'amount' => 5,
                'reserved_amount' => 5,
            ],
            $item2->getKey() => [
                'amount' => 5,
                'reserved_amount' => 3,
            ],
            $item3->getKey() => [
                'amount' => 5,
                'reserved_amount' => 1,
            ],
        ]);

        $offer = MarketOffer::factory()->create([
            'user_id' => $this->user->getKey(),
        ]);

        $offer->items()->createMany([
            [
                'item_id' => $item1->getKey(),
                'amount' => 5,
            ],
            [
                'item_id' => $item2->getKey(),
                'amount' => 3,
            ],
            [
                'item_id' => $item3->getKey(),
                'amount' => 1,
            ],
        ]);

        $tradeOffer = TradeOffer::create([
            'user_id' => $buyer->getKey(),
            'offerable_id' => $offer->getKey(),
            'offerable_type' => MarketOffer::class,
            'type' => OfferTypeEnum::BUY->value,
            'status' => MarketOfferRequestStatusEnum::PENDING->value,
        ]);

        $tradeOffer->items()->attach([
            $item1->getKey() => [
                'amount' => 3,
            ],
            $item2->getKey() => [
                'amount' => 3,
            ],
            $item3->getKey() => [
                'amount' => 1,
            ],
        ]);

        $this->actingAs($this->user)->post("/market/{$tradeOffer->getKey()}/{$offer->getKey()}/reject");

        $this->assertDatabaseHas('trade_offers', [
            'id' => $tradeOffer->getKey(),
            'user_id' => $buyer->getKey(),
            'status' => MarketOfferRequestStatusEnum::REJECTED->value,
        ]);
    }

    public function test_offers_history(): void
    {
        $offer = MarketOffer::factory()->create([
            'user_id' => $this->user->getKey(),
            'status' => MarketOfferStatusEnum::EXPIRED,
        ]);

        MarketOffer::factory()->create([
            'user_id' => $this->user->getKey(),
            'status' => MarketOfferStatusEnum::ACTIVE,
        ]);

        MarketOffer::factory()->create([
            'user_id' => $this->user->getKey(),
            'status' => MarketOfferStatusEnum::FINISHED,
        ]);

        MarketOffer::factory()->create([
            'user_id' => $this->user->getKey(),
            'status' => MarketOfferStatusEnum::CANCELED,
        ]);

        $this->actingAs($this->user)->get('/market/history')
            ->assertInertia(
                fn(AssertableInertia $page) => $page
                    ->component('Market/MyOffers')
                    ->has(
                        'offers.data',
                        3,
                        fn(AssertableInertia $page) => $page
                            ->where('id', $offer->getKey())
                            ->etc()
                    )
            );
    }

    public function test_market_offer_expiration(): void
    {
        Mail::fake();
        $offer = MarketOffer::factory()->create([
            'user_id' => $this->user->getKey(),
            'expires_at' => now()->addDay(),
            'status' => MarketOfferStatusEnum::ACTIVE->value,
        ]);

        Bus::fake();

        SetMarketOfferStatusAsExpired::dispatch($offer)->delay($offer->expires_at);

        Bus::assertDispatched(SetMarketOfferStatusAsExpired::class);

        $job = new SetMarketOfferStatusAsExpired($offer);
        $job->handle();

        $this->assertEquals($offer->status, MarketOfferStatusEnum::EXPIRED);

        Mail::assertSent(MarketOfferExpired::class, function (MarketOfferExpired $mail) use ($offer) {
            return $mail->hasTo($offer->user->email);
        });
    }

    public function test_market_offer_expiration_job_delay(): void
    {
        Queue::fake();
        Carbon::setTestNow(now()->startOfDay());

        $offer = MarketOffer::factory()->create([
            'user_id' => $this->user->getKey(),
            'expires_at' => now()->addHours(6),
            'status' => MarketOfferStatusEnum::ACTIVE->value,
        ]);

        SetMarketOfferStatusAsExpired::dispatch($offer)->delay(3600);

        $this->assertEquals($offer->status, MarketOfferStatusEnum::ACTIVE);

        Queue::assertPushed(SetMarketOfferStatusAsExpired::class, function ($job) use ($offer) {
            return $job->delay === 3600;
        });
    }
}