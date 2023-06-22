<?php

namespace App\Actions\Market\OfferRequests;

use App\Enums\MarketOfferRequestStatusEnum;
use App\Models\Market\MarketOffer;
use App\Models\Market\OfferRequest;
use Illuminate\Database\Eloquent\Builder;

class CancelOffersWithSoldItems
{
    public function handle(OfferRequest $request): void
    {
        if ($request->offerable instanceof MarketOffer) {
            $cosmetic_ids = $request->cosmetics->pluck('pivot.cosmetic_id')->toArray();
        
            $tradeRequestsQuery = $request->offerable->offers()
                ->whereNot('id', $request->getKey())
                ->whereNotIn('status', [
                    MarketOfferRequestStatusEnum::REJECTED->value,
                    MarketOfferRequestStatusEnum::ACCEPTED->value,
                ])
                ->whereHas('cosmetics', function (Builder $query) use ($cosmetic_ids) {
                    $query->whereIn('offer_request_item.cosmetic_id', $cosmetic_ids);
                });

            $tradeRequestsQuery->update([
                'status' => MarketOfferRequestStatusEnum::REJECTED->value,
            ]);
        
            $tradeRequestsQuery->get()->each(function (OfferRequest $request) {
                //TODO: dispatch job to notify users
            });
        }
    }
}
