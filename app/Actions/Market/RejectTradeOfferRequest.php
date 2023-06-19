<?php

namespace App\Actions\Market;

use App\Enums\MarketOfferRequestStatusEnum;
use App\Models\Market\OfferRequest;

class RejectTradeOfferRequest
{
    public function handle(OfferRequest $request): void
    {
        $request->update([
            'status' => MarketOfferRequestStatusEnum::REJECTED,
        ]);
    }
}
