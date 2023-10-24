<?php

namespace Tests\Feature;

use App\Models\Character\Character;
use App\Models\User;
use Tests\TestCase;

class GuildTest extends TestCase
{
    public User $user;
    public Character $character;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->character = Character::factory()->create([
            'user_id' => $this->user->id,
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->actingAs($this->user)->post('/guild', [
            'name' => 'test guild',
            'recruiting' => false,
            'leader_id' => $this->character->getKey(),
        ]);
        dd($response);
        $response->assertStatus(200);
    }
}
