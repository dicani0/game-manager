<?php

namespace App\Tasks\Market;

use App\Actions\Market\CreateMarketOfferRequest;
use App\Data\Market\CreateMarketOfferDto;
use App\Data\Market\CreateMarketOfferRequestDto;

class CreateMarketOfferRequestTask
{
    public function __construct(
        protected CreateMarketOfferRequest $action
    )
    {
    }

    public function handle(CreateMarketOfferRequestDto $dto, \Closure $next): CreateMarketOfferRequestDto
    {
        $this->action->handle($dto);
        return $next($dto);
    }
}
