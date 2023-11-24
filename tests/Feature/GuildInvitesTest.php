<?php


use App\Enums\GuildInvitationStatus;
use App\Enums\GuildRoleEnum;
use App\Events\Guild\NewGuildCharacter;
use App\Models\Character\Character;
use App\Models\Guild\Guild;
use App\Models\Guild\GuildCharacter;
use App\Models\Guild\GuildInvitation;
use App\Models\User;
use Tests\TestCase;

class GuildInvitesTest extends TestCase
{
    public User $user;
    public Character $character;
    public Guild $guild;
    public GuildCharacter $guildCharacter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->character = Character::factory()->create([
            'name' => 'main_character',
            'user_id' => $this->user->id,
        ]);

        $this->guild = Guild::factory()->create();

        $this->guildCharacter = GuildCharacter::create([
            'guild_id' => $this->guild->getKey(),
            'character_id' => $this->character->getKey(),
            'role' => GuildRoleEnum::LEADER->value,
        ]);
    }

    public function test_invite_player_to_guild_ok(): void
    {
        $anotherUser = User::factory()->create();

        $character = Character::factory()->create([
            'user_id' => $anotherUser->getKey(),
        ]);

        $this->actingAs($this->user)->post('/guilds/' . $this->guild->getKey() . '/invite/' . $character->getKey());

        $this->assertDatabaseHas('guild_invitations', [
            'guild_id' => $this->guild->getKey(),
            'character_id' => $character->getKey(),
            'status' => GuildInvitationStatus::PENDING->value,
        ]);
    }

    public function test_invite_player_to_guild_as_member(): void
    {
        $anotherUser = User::factory()->create();

        $character = Character::factory()->create([
            'user_id' => $anotherUser->getKey(),
        ]);

        $this->guildCharacter->update([
            'role' => GuildRoleEnum::MEMBER,
        ]);

        $this->actingAs($this->user)->post('/guilds/' . $this->guild->getKey() . '/invite/' . $character->getKey());

        $this->assertEquals(session('errors')->getBag('default')->first(), "This action is unauthorized.");

        $this->assertDatabaseMissing('guild_invitations', [
            'guild_id' => $this->guild->getKey(),
            'character_id' => $character->getKey(),
            'status' => GuildInvitationStatus::PENDING->value,
        ]);
    }

    public function test_accept_invite_ok(): void
    {
        Event::fake();
        $anotherUser = User::factory()->create();

        $character = Character::factory()->create([
            'user_id' => $anotherUser->getKey(),
        ]);

        $guildInvitation = GuildInvitation::create([
            'guild_id' => $this->guild->getKey(),
            'character_id' => $character->getKey(),
            'status' => GuildInvitationStatus::PENDING,
            'role' => GuildRoleEnum::MEMBER,
        ]);

        $this
            ->actingAs($anotherUser)
            ->post('/guilds/invites/' . $guildInvitation->getKey() . '/accept');

        Event::assertDispatched(NewGuildCharacter::class);

        $this->assertDatabaseHas('guild_character', [
            'guild_id' => $this->guild->getKey(),
            'character_id' => $character->getKey(),
            'role' => GuildRoleEnum::MEMBER->value,
        ]);

        $this->assertDatabaseHas('guild_invitations', [
            'guild_id' => $this->guild->getKey(),
            'character_id' => $character->getKey(),
            'status' => GuildInvitationStatus::ACCEPTED->value,
        ]);
    }

    public function test_reject_invite_ok(): void
    {
        Event::fake();
        $anotherUser = User::factory()->create();

        $character = Character::factory()->create([
            'user_id' => $anotherUser->getKey(),
        ]);

        $guildInvitation = GuildInvitation::create([
            'guild_id' => $this->guild->getKey(),
            'character_id' => $character->getKey(),
            'status' => GuildInvitationStatus::PENDING,
            'role' => GuildRoleEnum::MEMBER,
        ]);

        $this
            ->actingAs($anotherUser)
            ->post('/guilds/invites/' . $guildInvitation->getKey() . '/reject');

        $this->assertDatabaseHas('guild_invitations', [
            'guild_id' => $this->guild->getKey(),
            'character_id' => $character->getKey(),
            'status' => GuildInvitationStatus::REJECTED->value,
        ]);
    }

    public function test_accept_invite_not_own_character(): void
    {
        Event::fake();
        $anotherUser = User::factory()->create();

        $character = Character::factory()->create([
            'user_id' => $anotherUser->getKey(),
        ]);

        $guildInvitation = GuildInvitation::create([
            'guild_id' => $this->guild->getKey(),
            'character_id' => $character->getKey(),
            'status' => GuildInvitationStatus::PENDING,
            'role' => GuildRoleEnum::MEMBER,
        ]);

        $this
            ->actingAs($this->user)
            ->post('/guilds/invites/' . $guildInvitation->getKey() . '/accept');

        $this->assertEquals(session('errors')->getBag('default')->first(), "You do not own this character.");

        Event::assertNotDispatched(NewGuildCharacter::class);

        $this->assertDatabaseMissing('guild_character', [
            'guild_id' => $this->guild->getKey(),
            'character_id' => $character->getKey(),
            'role' => GuildRoleEnum::MEMBER->value,
        ]);

        $this->assertDatabaseHas('guild_invitations', [
            'guild_id' => $this->guild->getKey(),
            'character_id' => $character->getKey(),
            'status' => GuildInvitationStatus::PENDING->value,
        ]);
    }

    public function test_reject_invite_not_own_character(): void
    {
        Event::fake();
        $anotherUser = User::factory()->create();

        $character = Character::factory()->create([
            'user_id' => $anotherUser->getKey(),
        ]);

        $guildInvitation = GuildInvitation::create([
            'guild_id' => $this->guild->getKey(),
            'character_id' => $character->getKey(),
            'status' => GuildInvitationStatus::PENDING,
            'role' => GuildRoleEnum::MEMBER,
        ]);

        $this
            ->actingAs($this->user)
            ->post('/guilds/invites/' . $guildInvitation->getKey() . '/reject');

        $this->assertEquals(session('errors')->getBag('default')->first(), "You do not own this character.");

        Event::assertNotDispatched(NewGuildCharacter::class);

        $this->assertDatabaseMissing('guild_character', [
            'guild_id' => $this->guild->getKey(),
            'character_id' => $character->getKey(),
            'role' => GuildRoleEnum::MEMBER->value,
        ]);

        $this->assertDatabaseHas('guild_invitations', [
            'guild_id' => $this->guild->getKey(),
            'character_id' => $character->getKey(),
            'status' => GuildInvitationStatus::PENDING->value,
        ]);
    }

    /** @dataProvider statusProvider */
    public function test_react_invite_invitation_is_not_pending(string $action, GuildInvitationStatus $status): void
    {
        Event::fake();
        $anotherUser = User::factory()->create();

        $character = Character::factory()->create([
            'user_id' => $anotherUser->getKey(),
        ]);

        $guildInvitation = GuildInvitation::create([
            'guild_id' => $this->guild->getKey(),
            'character_id' => $character->getKey(),
            'status' => $status,
            'role' => GuildRoleEnum::MEMBER,
        ]);

        $this
            ->actingAs($anotherUser)
            ->post('/guilds/invites/' . $guildInvitation->getKey() . '/' . $action);

        $this->assertEquals(session('errors')->getBag('default')->first(), "This invitation is no longer valid.");

        Event::assertNotDispatched(NewGuildCharacter::class);

        $this->assertDatabaseMissing('guild_character', [
            'guild_id' => $this->guild->getKey(),
            'character_id' => $character->getKey(),
            'role' => GuildRoleEnum::MEMBER->value,
        ]);

        $this->assertDatabaseHas('guild_invitations', [
            'guild_id' => $this->guild->getKey(),
            'character_id' => $character->getKey(),
            'status' => $status->value,
        ]);
    }

    /** @dataProvider statusProvider */
    public function test_react_invite_invitation_already_in_guild(string $action, GuildInvitationStatus $status): void
    {
        Event::fake();
        $guild = Guild::factory()->create();
        $anotherUser = User::factory()->create();

        $character = Character::factory()->create([
            'user_id' => $anotherUser->getKey(),
        ]);

        GuildCharacter::create([
            'guild_id' => $guild->getKey(),
            'character_id' => $character->getKey(),
            'role' => GuildRoleEnum::MEMBER,
        ]);

        $guildInvitation = GuildInvitation::create([
            'guild_id' => $this->guild->getKey(),
            'character_id' => $character->getKey(),
            'status' => $status,
            'role' => GuildRoleEnum::MEMBER,
        ]);

        $this
            ->actingAs($anotherUser)
            ->post('/guilds/invites/' . $guildInvitation->getKey() . '/' . $action);

        $this->assertEquals(session('errors')->getBag('default')->first(), "This character is already in a guild.");

        Event::assertNotDispatched(NewGuildCharacter::class);

        $this->assertDatabaseMissing('guild_character', [
            'guild_id' => $this->guild->getKey(),
            'character_id' => $character->getKey(),
            'role' => GuildRoleEnum::MEMBER->value,
        ]);

        $this->assertDatabaseHas('guild_invitations', [
            'guild_id' => $this->guild->getKey(),
            'character_id' => $character->getKey(),
            'status' => $status->value,
        ]);
    }

    public static function statusProvider(): array
    {
        return [
            ['accept', GuildInvitationStatus::ACCEPTED],
            ['accept', GuildInvitationStatus::REJECTED],
            ['accept', GuildInvitationStatus::CANCELED],
            ['reject', GuildInvitationStatus::ACCEPTED],
            ['reject', GuildInvitationStatus::REJECTED],
            ['reject', GuildInvitationStatus::CANCELED],
        ];
    }

}
