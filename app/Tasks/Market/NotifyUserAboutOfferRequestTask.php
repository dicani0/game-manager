<?php

namespace App\Tasks\Market;

use App\Actions\Market\OfferRequests\NotifyUserAboutOfferRequest;
use App\Data\Market\CreateMarketOfferRequestDto;

class NotifyUserAboutOfferRequestTask
{
    public function __construct(
        protected NotifyUserAboutOfferRequest $action
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
