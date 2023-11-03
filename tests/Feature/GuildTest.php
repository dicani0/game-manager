<?php

namespace Tests\Feature;

use App\Enums\GuildRoleEnum;
use App\Models\Character\Character;
use App\Models\Guild\Guild;
use App\Models\Guild\GuildCharacter;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
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
    public function test_create_guild(): void
    {
        $this->actingAs($this->user)->post('/guilds', [
            'name' => 'test guild',
            'recruiting' => false,
            'leader_id' => $this->character->getKey(),
        ]);

        $this->assertDatabaseHas('guilds', [
            'name' => 'test guild',
            'recruiting' => false,
        ]);

        $this->assertDatabaseHas('guild_character', [
            'guild_id' => 1,
            'character_id' => $this->character->getKey(),
            'role' => GuildRoleEnum::LEADER->value,
        ]);
    }

    public function test_update_guild(): void
    {
        $guild = Guild::factory()->create([
            'recruiting' => false,
        ]);

        GuildCharacter::create([
            'guild_id' => $guild->getKey(),
            'character_id' => $this->character->getKey(),
            'role' => GuildRoleEnum::LEADER->value,
        ]);

        $this->actingAs($this->user)
            ->patch('/guilds/' . $guild->getKey(), [
                'name' => 'test guild',
                'description' => 'test description',
                'recruiting' => false,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('guilds', [
            'name' => 'test guild',
            'description' => 'test description',
            'recruiting' => false,
        ]);
    }

    public function test_update_guild_not_a_leader(): void
    {
        $guild = Guild::factory()->create([
            'recruiting' => false,
        ]);

        GuildCharacter::create([
            'guild_id' => $guild->getKey(),
            'character_id' => $this->character->getKey(),
            'role' => GuildRoleEnum::MEMBER->value,
        ]);

        $response = $this->actingAs($this->user)
            ->patch('/guilds/' . $guild->getKey(), [
                'name' => 'test guild',
                'description' => 'test description',
                'recruiting' => false,
            ]);

        $response->assertRedirect();

        $this->assertEquals(session('errors')->getBag('default')->first(), 'This action is unauthorized.');

        $this->assertDatabaseMissing('guilds', [
            'name' => 'test guild',
            'description' => 'test description',
            'recruiting' => false,
        ]);
    }
}