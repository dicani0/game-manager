<?php

namespace App\Actions\Market\TradeOffers;

use App\Data\Market\CreateTradeOfferDto;
use App\Mail\MarketOfferRequest;
use Illuminate\Support\Facades\Mail;

class NotifyUserAboutTradeOffer
{
    /**
     * @throws \Exception
     */
    public function handle(CreateTradeOfferDto $dto): void
    {
        $user = $dto->offer->user;
        Mail::to($user->email)->send(new MarketOfferRequest($dto->tradeOffer, $dto->offer));
    }
}
