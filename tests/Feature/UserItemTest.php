<?php

namespace Tests\Feature;

use App\Exports\ItemsExport;
use App\Models\Items\Item;
use App\Models\Items\UserItem;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class UserItemTest extends TestCase
{
    public User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_import_items(): void
    {
        $content = '2x Stuffed Dragon Furniture	-
	            2x Death Knight Outfit	-
	            2x Red Sword Aura	-';

        $response = $this->actingAs($this->user)->post('/items/import', [
            'content' => $content,
        ]);
        $response->assertRedirect();

        $this->assertDatabaseCount('user_item', 3);
    }

    public function test_update_item_amount(): void
    {
        $item = Item::factory()->create();
        $item = UserItem::factory()->create([
            'user_id' => $this->user->id,
            'item_id' => $item->getKey(),
            'used_amount' => 0,
            'sold_amount' => 0,
        ]);

        $response = $this->actingAs($this->user)->put('/items/'.$item->getKey(), [
            'amount' => 15,
        ]);

        $response->assertSessionHasErrors('sold_amount');
        $response->assertSessionHasErrors('used_amount');

        $response = $this->actingAs($this->user)->put('/items/'.$item->getKey(), [
            'amount' => 15,
            'sold_amount' => 10,
            'used_amount' => 10,
        ]);

        $response->assertSessionHasErrors('amount');

        $response = $this->actingAs($this->user)->put('/items/'.$item->getKey(), [
            'amount' => 15,
            'sold_amount' => 5,
            'used_amount' => 5,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('user_item', [
            'id' => $item->getKey(),
            'amount' => 15,
            'sold_amount' => 5,
            'used_amount' => 5,
        ]);
    }

    public function test_update_other_user_items(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthorizationException::class);

        $testUser = User::factory()->create();

        $item = Item::factory()->create();
        $item = UserItem::factory()->create([
            'user_id' => $this->user->getKey(),
            'item_id' => $item->getKey(),
            'amount' => 3,
            'used_amount' => 0,
            'sold_amount' => 0,
        ]);

        $this->actingAs($testUser)->put('/items/'.$item->getKey(), [
            'amount' => 15,
            'sold_amount' => 5,
            'used_amount' => 5,
        ]);
    }

    public function test_delete_item(): void
    {
        $item = Item::factory()->create();
        $item = UserItem::factory()->create([
            'user_id' => $this->user->getKey(),
            'item_id' => $item->getKey(),
        ]);

        $response = $this->actingAs($this->user)->delete('/items/'.$item->getKey());
        $response->assertRedirect();

        $this->assertDatabaseMissing('user_item', [
            'id' => $item->getKey(),
        ]);
    }

    public function test_delete_other_user_item(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthorizationException::class);

        $testUser = User::factory()->create();

        $item = Item::factory()->create();
        $item = UserItem::factory()->create([
            'item_id' => $item->getKey(),
            'user_id' => $this->user->getKey(),
        ]);

        $this->actingAs($testUser)->delete('/items/'.$item->getKey());
    }

    public function test_export_user_items(): void
    {
        Excel::fake();

        $items = Item::factory()->count(10)->create();

        $items->each(function (Item $item) {
            UserItem::factory()->create([
                'user_id' => $this->user->getKey(),
                'item_id' => $item->getKey(),
                'amount' => 10,
            ]);
        });

        $items = Item::factory()->count(5)->create();

        $items->each(function (Item $item) {
            UserItem::factory()->create([
                'user_id' => $this->user->getKey(),
                'item_id' => $item->getKey(),
                'amount' => 1,
            ]);
        });

        $response = $this->actingAs($this->user)->get('/items/export');

        Excel::assertDownloaded('standard_items.xlsx', function (ItemsExport $excel) {
            return $excel->collection()->count() === 15;
        });

        $response = $this->actingAs($this->user)->get('/items/export?type=sellable');
        Excel::assertDownloaded('sellable_items.xlsx', function (ItemsExport $excel) {
            return $excel->collection()->count() === 10;
        });
    }
}
