<?php

namespace App\Events\Guild;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvitedToGuild implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(private readonly User $user)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('guild-invite.' . $this->user->getKey()),
        ];
    }

    public function broadcastAs(): string
    {
        return 'InvitedToGuild';
    }
}
