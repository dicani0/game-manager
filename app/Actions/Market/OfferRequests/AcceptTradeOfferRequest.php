<?php

namespace App\Actions\Market\OfferRequests;

use App\Enums\MarketOfferRequestStatusEnum;
use App\Models\Market\OfferRequest;

class AcceptTradeOfferRequest
{
    public function handle(OfferRequest $request): void
    {
        $request->update([
            'status' => MarketOfferRequestStatusEnum::ACCEPTED->value,
        ]);
    }
}
