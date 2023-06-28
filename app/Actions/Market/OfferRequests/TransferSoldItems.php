<?php

namespace App\Actions\Market\OfferRequests;

use App\Models\Market\OfferRequest;

class TransferSoldItems
{
    public function handle(OfferRequest $request): void
    {
        $request->creator->cosmetics()->attach($request->cosmetics->map(function ($cosmetic) {
            return [
                'cosmetic_id' => $cosmetic->getKey(),
                'bought_amount' => $cosmetic->pivot->amount,
            ];
        })->toArray());
    }
}