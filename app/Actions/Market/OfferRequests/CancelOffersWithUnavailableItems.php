<?php

namespace App\Actions\Market\OfferRequests;

use App\Enums\MarketOfferRequestStatusEnum;
use App\Models\Cosmetics\Cosmetic;
use App\Models\Market\MarketOffer;
use App\Models\Market\OfferRequest;
use Illuminate\Database\Eloquent\Builder;

class CancelOffersWithUnavailableItems
{
    public function handle(OfferRequest $request): void
    {
        if ($request->offerable instanceof MarketOffer) {
            $cosmetic_ids = $request->cosmetics->pluck('pivot.cosmetic_id')->toArray();

            $marketOffer = $request->offerable;

            $tradeRequests = $marketOffer->offers()
                ->whereNot('id', $request->getKey())
                ->whereNotIn('status', [
                    MarketOfferRequestStatusEnum::REJECTED->value,
                    MarketOfferRequestStatusEnum::ACCEPTED->value,
                ])
                ->whereHas('cosmetics', function (Builder $query) use ($cosmetic_ids) {
                    $query->whereIn('offer_request_item.cosmetic_id', $cosmetic_ids);
                })
                ->get();


            $tradeRequests->each(function (OfferRequest $request) use ($marketOffer) {
                $shouldReject = !$request->cosmetics->every(function (Cosmetic $cosmetic) use ($marketOffer) {
                    $item = $marketOffer->items->where('cosmetic_id', $cosmetic->getKey())->first();
                    return $item && $item->amount >= $cosmetic->pivot->amount;
                });      
                
                if ($shouldReject) {
                    $request->update([
                        'status' => MarketOfferRequestStatusEnum::REJECTED->value,
                    ]);

                    //TODO Notify user that his offer was rejected
                }
            });
        }
    }
}