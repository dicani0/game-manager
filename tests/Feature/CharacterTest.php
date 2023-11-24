<?php


use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class CharacterTest extends TestCase
{
    use RefreshDatabase;

    public User $user;

    public function test_create_character(): void
    {
        $response = $this->actingAs($this->user)->post('/characters', [
            'name' => 'test',
            'vocation' => 'knight',
        ]);

        //TODO: Remove this, it's just for debugging
        dd($response);

        $response->assertInertia(fn(AssertableInertia $page) => $page
            ->component('Character/Character')
            ->has('characters', 1)
            ->where('characters.0.name', 'test')
            ->where('characters.0.vocation', 'knight')
        );
    }

    public function test_create_character_unauthorized(): void
    {
        $response = $this->post('/characters', [
            'name' => 'test',
            'vocation' => 'knight',
        ]);
        $response->assertRedirect('/auth/login');
    }

    public function test_edit_character(): void
    {
        $character = $this->user->characters()->create([
            'name' => 'test',
            'vocation' => 'knight',
        ]);

        $response = $this->actingAs($this->user)->get('/characters/edit/' . $character->id);
        $response->assertInertia(fn(AssertableInertia $page) => $page
            ->component('Character/Edit')
            ->where('character.name', 'test')
            ->where('character.vocation', 'knight')
        );
    }

    public function test_cannot_edit_not_owned_character(): void
    {
        $character = $this->user->characters()->create([
            'name' => 'test',
            'vocation' => 'knight',
        ]);

        $user2 = User::factory()->create();

        $response = $this->actingAs($user2)->get('/characters/edit/' . $character->getKey());
        $response->assertRedirect();
    }

    public function test_update_character(): void
    {
        $character = $this->user->characters()->create([
            'name' => 'test',
            'vocation' => 'knight',
        ]);

        $response = $this->actingAs($this->user)->put('/characters/' . $character->id, [
            'name' => 'test2',
            'vocation' => 'druid',
        ]);

        $response->assertRedirect('/characters');

        $this->assertDatabaseHas('characters', [
            'id' => $character->getKey(),
            'name' => 'test2',
            'vocation' => 'druid',
        ]);
    }

    public function test_cannot_update_not_owned_character(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(AuthorizationException::class);
        $character = $this->user->characters()->create([
            'name' => 'test',
            'vocation' => 'knight',
        ]);

        $user2 = User::factory()->create();

        $this->actingAs($user2)->put('/characters/' . $character->id, [
            'name' => 'test2',
            'vocation' => 'druid',
        ]);
    }

    public function test_delete_character(): void
    {
        $character = $this->user->characters()->create([
            'name' => 'test',
            'vocation' => 'knight',
        ]);

        $response = $this->actingAs($this->user)->delete('/characters/' . $character->id);

        $response->assertRedirect('/characters');

        $this->assertDatabaseMissing('characters', [
            'id' => $character->getKey(),
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}
