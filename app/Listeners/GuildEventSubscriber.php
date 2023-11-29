<?php

namespace App\Listeners;

use App\Events\Guild\InvitedToGuild;
use App\Events\Guild\NewGuildCharacter;
use App\Models\User;
use App\Notifications\Guild\GuildInvitationNotification;
use App\Notifications\Guild\NewGuildMemberNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Events\Dispatcher;

class GuildEventSubscriber
{
    public function notifyUserInvitedToGuild(InvitedToGuild $event): void
    {
        $event->user->notify(new GuildInvitationNotification($event->invitation));
    }

    public function notifyGuildMembersAboutNewGuildCharacter(NewGuildCharacter $event): void
    {
        $usersToNotify = User::query()
            ->whereNot('id', $event->guildCharacter->character->user_id)
            ->whereHas('characters', function (Builder $query) use ($event) {
                $query->whereHas('guildCharacter', function (Builder $query) use ($event) {
                    $query->where('guild_id', $event->guildCharacter->guild_id);
                });
            })
            ->get();

        $usersToNotify->each(function (User $user) use ($event) {
            $user->notify(new NewGuildMemberNotification($event->guildCharacter));
        });
    }

    public function subscribe(Dispatcher $events): array
    {
        return [
            InvitedToGuild::class => 'notifyUserInvitedToGuild',
            NewGuildCharacter::class => 'notifyGuildMembersAboutNewGuildCharacter',
        ];
    }
}
