<?php

namespace Tests\Feature;

use App\Enums\GuildRoleEnum;
use App\Models\Character\Character;
use App\Models\Guild\Guild;
use App\Models\Guild\GuildCharacter;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
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
            'name' => 'main_character',
            'user_id' => $this->user->id,
        ]);
    }

    public function test_show_user_has_all_permissions(): void
    {
        $guild = Guild::factory()->create();

        GuildCharacter::create([
            'guild_id' => $guild->getKey(),
            'character_id' => $this->character->getKey(),
            'role' => GuildRoleEnum::LEADER->value,
        ]);

        $this->actingAs($this->user)->get('/guilds/' . $guild->name)
            ->assertInertia(fn(AssertableInertia $assert) => $assert
                ->component('Guild/GuildShow')
                ->has('can', fn(AssertableInertia $page) => $page
                    ->where('edit', true)
                    ->where('invite', true)
                    ->where('cancel-invitation', true)
                )
            );
    }

    public function test_show_user_has_no_permissions(): void
    {
        $guild = Guild::factory()->create();

        GuildCharacter::create([
            'guild_id' => $guild->getKey(),
            'character_id' => $this->character->getKey(),
            'role' => GuildRoleEnum::MEMBER->value,
        ]);

        $this->actingAs($this->user)->get('/guilds/' . $guild->name)
            ->assertInertia(fn(AssertableInertia $assert) => $assert
                ->component('Guild/GuildShow')
                ->has('can', fn(AssertableInertia $page) => $page
                    ->where('edit', false)
                    ->where('invite', false)
                    ->where('cancel-invitation', false)
                )
            );
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

        $guild = Guild::first();

        $this->assertDatabaseHas('guilds', [
            'name' => 'test guild',
            'recruiting' => false,
        ]);

        $this->assertDatabaseHas('guild_character', [
            'guild_id' => $guild->getKey(),
            'character_id' => $this->character->getKey(),
            'role' => GuildRoleEnum::LEADER->value,
        ]);
    }

    public function test_update_guild_ok(): void
    {
        $guild = Guild::factory()->create([
            'recruiting' => false,
        ]);

        GuildCharacter::create([
            'guild_id' => $guild->getKey(),
            'character_id' => $this->character->getKey(),
            'role' => GuildRoleEnum::LEADER->value,
        ]);

        $secondCharacter = Character::factory()->create([
            'user_id' => $this->user->getKey(),
            'name' => 'new_leader',
        ]);

        $newLeader = GuildCharacter::create([
            'guild_id' => $guild->getKey(),
            'character_id' => $secondCharacter->getKey(),
            'role' => GuildRoleEnum::MEMBER->value,
        ]);

        $this->actingAs($this->user)
            ->patch('/guilds/' . $guild->getKey(), [
                'name' => 'test guild',
                'description' => 'test description',
                'recruiting' => false,
                'leader_id' => $newLeader->getKey(),
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('guilds', [
            'name' => 'test guild',
            'description' => 'test description',
            'recruiting' => false,
        ]);

        $this->assertDatabaseHas('guild_character', [
            'guild_id' => $guild->getKey(),
            'character_id' => $this->character->getKey(),
            'role' => GuildRoleEnum::MEMBER->value,
        ]);

        $this->assertDatabaseHas('guild_character', [
            'guild_id' => $guild->getKey(),
            'character_id' => $secondCharacter->getKey(),
            'role' => GuildRoleEnum::LEADER->value,
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
                'leader_id' => $this->character->getKey(),
            ]);

        $response->assertRedirect();

        $this->assertEquals(session('errors')->getBag('default')->first(), 'This action is unauthorized.');

        $this->assertDatabaseMissing('guilds', [
            'name' => 'test guild',
            'description' => 'test description',
            'recruiting' => false,
        ]);
    }

    public function test_kick_from_guild_as_leader_ok(): void
    {
        $guild = Guild::factory()->create([
            'recruiting' => false,
        ]);

        GuildCharacter::create([
            'guild_id' => $guild->getKey(),
            'character_id' => $this->character->getKey(),
            'role' => GuildRoleEnum::LEADER->value,
        ]);

        $secondCharacter = Character::factory()->create([
            'user_id' => $this->user->getKey(),
        ]);

        $kickedCharacter = GuildCharacter::create([
            'guild_id' => $guild->getKey(),
            'character_id' => $secondCharacter->getKey(),
            'role' => GuildRoleEnum::MEMBER->value,
        ]);

        $this->actingAs($this->user)
            ->delete('/guilds/' . $guild->getKey() . '/kick/' . $kickedCharacter->getKey());

        $this->assertDatabaseMissing('guild_character', [
            'guild_id' => $guild->getKey(),
            'id' => $kickedCharacter->getKey(),
        ]);
    }

    public function test_kick_from_guild_as_vice_leader_ok(): void
    {
        $guild = Guild::factory()->create([
            'recruiting' => false,
        ]);

        GuildCharacter::create([
            'guild_id' => $guild->getKey(),
            'character_id' => $this->character->getKey(),
            'role' => GuildRoleEnum::VICE_LEADER->value,
        ]);

        $secondCharacter = Character::factory()->create([
            'user_id' => $this->user->getKey(),
        ]);

        $kickedCharacter = GuildCharacter::create([
            'guild_id' => $guild->getKey(),
            'character_id' => $secondCharacter->getKey(),
            'role' => GuildRoleEnum::MEMBER->value,
        ]);

        $this->actingAs($this->user)
            ->delete('/guilds/' . $guild->getKey() . '/kick/' . $kickedCharacter->getKey());

        $this->assertDatabaseMissing('guild_character', [
            'guild_id' => $guild->getKey(),
            'id' => $kickedCharacter->getKey(),
        ]);
    }

    public function test_cant_kick_leader_as_vice_leader(): void
    {
        $guild = Guild::factory()->create([
            'recruiting' => false,
        ]);

        GuildCharacter::create([
            'guild_id' => $guild->getKey(),
            'character_id' => $this->character->getKey(),
            'role' => GuildRoleEnum::VICE_LEADER->value,
        ]);

        $secondCharacter = Character::factory()->create([
            'user_id' => $this->user->getKey(),
        ]);

        $kickedCharacter = GuildCharacter::create([
            'guild_id' => $guild->getKey(),
            'character_id' => $secondCharacter->getKey(),
            'role' => GuildRoleEnum::LEADER->value,
        ]);

        $res = $this->actingAs($this->user)
            ->delete('/guilds/' . $guild->getKey() . '/kick/' . $kickedCharacter->getKey());

        $this->assertEquals(session('errors')->getBag('default')->first(), 'This action is unauthorized.');

        $this->assertDatabaseHas('guild_character', [
            'guild_id' => $guild->getKey(),
            'id' => $kickedCharacter->getKey(),
        ]);
    }

    public function test_cant_kick_vice_leader_as_vice_leader(): void
    {
        $guild = Guild::factory()->create([
            'recruiting' => false,
        ]);

        GuildCharacter::create([
            'guild_id' => $guild->getKey(),
            'character_id' => $this->character->getKey(),
            'role' => GuildRoleEnum::VICE_LEADER->value,
        ]);

        $secondCharacter = Character::factory()->create([
            'user_id' => $this->user->getKey(),
        ]);

        $kickedCharacter = GuildCharacter::create([
            'guild_id' => $guild->getKey(),
            'character_id' => $secondCharacter->getKey(),
            'role' => GuildRoleEnum::VICE_LEADER->value,
        ]);

        $this->actingAs($this->user)
            ->delete('/guilds/' . $guild->getKey() . '/kick/' . $kickedCharacter->getKey());

        $this->assertEquals(session('errors')->getBag('default')->first(), 'This action is unauthorized.');

        $this->assertDatabaseHas('guild_character', [
            'guild_id' => $guild->getKey(),
            'id' => $kickedCharacter->getKey(),
        ]);
    }
}
