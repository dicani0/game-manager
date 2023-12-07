<?php

namespace App\Tasks\Market;

use App\Actions\Market\TradeOffers\AttachItemsToTradeOffer;
use App\Data\Market\CreateTradeOfferDto;

class AttachItemsToMarketOfferRequestTask
{
    public function __construct(
        protected AttachItemsToTradeOffer $action
    ) {
    }

    public function handle(CreateTradeOfferDto $dto, \Closure $next): CreateTradeOfferDto
    {
        $this->action->handle($dto);

        return $next($dto);
    }
}
