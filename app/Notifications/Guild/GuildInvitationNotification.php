<?php

namespace App\Notifications\Guild;

use App\Models\Guild\GuildInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class GuildInvitationNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly GuildInvitation $guildInvitation)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'guild_id' => $this->guildInvitation->guild_id,
            'character_id' => $this->guildInvitation->character_id,
            'message' => 'Your character ' . $this->guildInvitation->character->name . ' has been invited to join the guild ' .
                $this->guildInvitation->guild->name,
            'link' => url('/guilds/invites'),
        ];
    }
}
