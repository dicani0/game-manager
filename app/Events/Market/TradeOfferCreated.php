<?php

namespace App\Events\Market;

use App\Models\Market\TradeOffer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TradeOfferCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public TradeOffer $tradeOffer;

    public function __construct(TradeOffer $tradeOffer)
    {
        $this->tradeOffer = $tradeOffer;
        Log::info('Event is initialized for broadcasting.');
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('trade-offers.' . $this->tradeOffer->offerable->user->getKey());
    }

    public function broadcastAs(): string
    {
        return 'TradeOfferCreated';
    }

    public function broadcastWith(): array
    {
        return [
            'aaaa' => 'bbbb',
        ];
    }
}
