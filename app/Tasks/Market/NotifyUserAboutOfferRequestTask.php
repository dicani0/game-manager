<?php

namespace App\Tasks\Market;

use App\Actions\Market\TradeOffers\NotifyUserAboutTradeOffer;
use App\Data\Market\CreateTradeOfferDto;

class NotifyUserAboutOfferRequestTask
{
    public function __construct(
        protected NotifyUserAboutTradeOffer $action
    )
    {
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
