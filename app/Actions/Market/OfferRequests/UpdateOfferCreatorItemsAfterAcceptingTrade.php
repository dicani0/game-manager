<?php

namespace App\Actions\Market\OfferRequests;

use App\Models\Cosmetics\Cosmetic;
use App\Models\Cosmetics\UserCosmetic;
use App\Models\Market\OfferRequest;
use Auth;

class UpdateOfferCreatorItemsAfterAcceptingTrade
{
    public function handle(OfferRequest $request): void
    {
        $request->cosmetics->each(function (Cosmetic $cosmetic) {
            $query = UserCosmetic::query()
                ->where('user_id', Auth::id())
                ->where('cosmetic_id', $cosmetic->getKey());

            $query->decrement('reserved_amount', $cosmetic->pivot->amount);
            $query->increment('sold_amount', $cosmetic->pivot->amount);
        });
    }
}
