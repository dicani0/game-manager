<?php

namespace App\Listeners;

use App\Events\Guild\InvitedToGuild;
use App\Notifications\Guild\GuildInvitationNotification;
use Illuminate\Events\Dispatcher;

class GuildEventSubscriber
{
    public function notifyUsers(InvitedToGuild $event): void
    {
        $event->user->notify(new GuildInvitationNotification($event->invitation));
    }

    public function subscribe(Dispatcher $events): array
    {
        return [
            InvitedToGuild::class => 'notifyUsers',
        ];
    }
}
