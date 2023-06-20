<?php

namespace App\Tasks\Market\OfferRequests;

use App\Actions\Market\OfferRequests\CreateMarketOfferRequest;
use App\Data\Market\CreateMarketOfferRequestDto;

readonly class CreateMarketOfferRequestTask
{
    public function __construct(
        protected CreateMarketOfferRequest $action
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function handle(CreateMarketOfferRequestDto $dto, \Closure $next): CreateMarketOfferRequestDto
    {
        $this->action->handle($dto);

        return $next($dto);
    }
}
