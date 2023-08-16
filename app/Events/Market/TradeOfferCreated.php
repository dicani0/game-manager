<?php

namespace App\Events\Market;

use App\Models\Market\TradeOffer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TradeOfferCreated implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public function __construct(private readonly TradeOffer $tradeOffer)
  {
  }

  public function broadcastOn(): Channel
  {
    return new PrivateChannel('trade-offer.' . $this->tradeOffer->offerable->user->getKey());
  }

  public function broadcastAs(): string
  {
    return 'TradeOfferCreated';
  }
}
