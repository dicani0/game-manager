<?php

namespace App\Events\Guild;

use App\Models\Guild\GuildCharacter;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewGuildCharacter implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public GuildCharacter $guildCharacter)
    {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('guild.' . $this->guildCharacter->guild->getKey()),
        ];
    }

    public function broadcastAs(): string
    {
        return 'NewGuildCharacter';
    }

    public function broadcastWith(): array
    {
        return [
            'character' => [
                'name' => $this->guildCharacter->character->name,
                'vocation' => $this->guildCharacter->character->vocation,
            ],
        ];
    }
}
