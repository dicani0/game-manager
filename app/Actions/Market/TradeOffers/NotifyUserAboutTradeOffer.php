<?php

namespace App\Actions\Market\TradeOffers;

use App\Data\Market\CreateTradeOfferDto;
use App\Models\User;
use App\Notifications\Market\TradeRequest;
use Exception;

class NotifyUserAboutTradeOffer
{
    /**
     * @throws Exception
     */
    public function handle(CreateTradeOfferDto $dto): void
    {
        $user = $dto->target instanceof User ? $dto->target : $dto->target->user;

        $user->notify(new TradeRequest($dto->tradeOffer, $dto->target));
    }
}
