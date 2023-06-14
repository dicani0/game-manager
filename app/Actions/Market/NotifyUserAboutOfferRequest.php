<?php

namespace App\Actions\Market;

use App\Data\Market\CreateMarketOfferRequestDto;
use App\Enums\OfferTypeEnum;
use App\Mail\MarketOfferRequest;
use Illuminate\Support\Facades\Mail;

class NotifyUserAboutOfferRequest
{
    /**
     * @throws \Exception
     */
    public function handle(CreateMarketOfferRequestDto $dto): void
    {
        $user = $dto->offer->user;
        Mail::to($user->email)->send(new MarketOfferRequest($dto->offerRequest, $dto->offer));
    }
}
