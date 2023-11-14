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

    /** @dataProvider statusProvider */
    public function test_accept_invite_invitation_is_not_pending(GuildInvitationStatus $status): void
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
            ->post('/guilds/invites/' . $guildInvitation->getKey() . '/accept');

        $this->assertEquals(session('errors')->getBag('default')->first(), "This action is unauthorized.");

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
            [GuildInvitationStatus::ACCEPTED],
            [GuildInvitationStatus::REJECTED],
            [GuildInvitationStatus::CANCELED],
        ];
    }

}
