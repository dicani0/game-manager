<?php

namespace App\Notifications\Guild;

use App\Models\Guild\GuildCharacter;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewGuildMemberNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly GuildCharacter $guildCharacter)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'character_name' => $this->guildCharacter->character->name,
            'guild_name' => $this->guildCharacter->guild->name,
            'message' => $this->guildCharacter->character->name . ' has joined the guild ' . $this->guildCharacter->guild->name,
        ];
    }
}
