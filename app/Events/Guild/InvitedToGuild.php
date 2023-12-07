<?php

namespace App\Events\Guild;

use App\Models\Guild\GuildInvitation;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvitedToGuild implements ShouldBroadcast, ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public readonly User $user, public readonly GuildInvitation $invitation)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('guild-invite.'.$this->user->getKey()),
        ];
    }

    public function broadcastAs(): string
    {
        return 'InvitedToGuild';
    }

    public function __serialize(): array
    {
        return [
            'user' => $this->user,
            'invitation' => $this->invitation,
        ];
    }

    public function __unserialize(array $values): void
    {
        $this->user = $values['user'];
        $this->invitation = $values['invitation'];
    }
}
