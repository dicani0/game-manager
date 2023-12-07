<?php

namespace App\Tasks\Market\OfferRequests;

use App\Actions\Market\TradeOffers\CreateTradeOffer;
use App\Data\Market\CreateTradeOfferDto;

readonly class CreateMarketOfferRequestTask
{
    public function __construct(
        protected CreateTradeOffer $action
    ) {
    }

    /**
     * @throws \Exception
     */
    public function handle(CreateTradeOfferDto $dto, \Closure $next): CreateTradeOfferDto
    {
        $this->action->handle($dto);

        return $next($dto);
    }
}
