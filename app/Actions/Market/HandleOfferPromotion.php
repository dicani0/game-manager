<?php

namespace App\Actions\Market;

use App\Data\Market\CreateMarketOfferDto;

class HandleOfferPromotion
{
    public function handle(CreateMarketOfferDto $dto): void
    {
        if ($dto->promoted) {
            $dto->user->decrement('available_promotes');
        }
    }
}
