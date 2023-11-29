<?php

namespace App\Actions\Market;

use App\Events\Market\NewMarketOffer;

class TriggerMarketReloadEvent
{
    public function handle(): void
    {
        event(new NewMarketOffer());
    }
}
