<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use App\Models\UserItem;
use Illuminate\Auth\Access\AuthorizationException;
use Tests\TestCase;

class ItemsTest extends TestCase
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

        $response = $this->actingAs($this->user)->withoutMiddleware(VerifyCsrfToken::class)->post('/items/import', [
            'content' => $content,
        ]);
        $response->assertRedirect();

        $this->assertDatabaseCount('user_items', 3);
    }

    public function test_update_item_amount(): void
    {
        $item = UserItem::factory()->create([
            'user_id' => $this->user->id,
            'amount' => 10,
            'used_amount' => 0,
            'sold_amount' => 0,
        ]);

        $response = $this->actingAs($this->user)->withoutMiddleware(VerifyCsrfToken::class)->put('/items/' . $item->getKey(), [
            'amount' => 15,
        ]);

        $response->assertSessionHasErrors('sold_amount');
        $response->assertSessionHasErrors('used_amount');

        $response = $this->actingAs($this->user)->withoutMiddleware(VerifyCsrfToken::class)->put('/items/' . $item->getKey(), [
            'amount' => 15,
            'sold_amount' => 10,
            'used_amount' => 10,
        ]);

        $response->assertSessionHasErrors('amount');

        $response = $this->actingAs($this->user)->withoutMiddleware(VerifyCsrfToken::class)->put('/items/' . $item->getKey(), [
            'amount' => 15,
            'sold_amount' => 5,
            'used_amount' => 5,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('user_items', [
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

        $item = UserItem::factory()->create([
            'user_id' => $this->user->getKey(),
            'amount' => 10,
            'used_amount' => 0,
            'sold_amount' => 0,
        ]);

        $this->actingAs($testUser)->withoutMiddleware(VerifyCsrfToken::class)->put('/items/' . $item->getKey(), [
            'amount' => 15,
            'sold_amount' => 5,
            'used_amount' => 5,
        ]);
    }

    public function test_delete_item(): void
    {
        $item = UserItem::factory()->create([
            'user_id' => $this->user->getKey(),
        ]);

        $response = $this->actingAs($this->user)->withoutMiddleware(VerifyCsrfToken::class)->delete('/items/' . $item->getKey());
        $response->assertRedirect();

        $this->assertDatabaseMissing('user_items', [
            'id' => $item->getKey(),
        ]);
    }

    public function test_delete_other_user_item(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthorizationException::class);

        $testUser = User::factory()->create();

        $item = UserItem::factory()->create([
            'user_id' => $this->user->getKey(),
        ]);

        $this->actingAs($testUser)->withoutMiddleware(VerifyCsrfToken::class)->delete('/items/' . $item->getKey());
    }
}
