<?php

namespace App\Http\Resources\Market;

use App\Enums\MarketOfferTypeEnum;
use App\Http\Resources\Auth\PublicUserResource;
use App\Models\Market\MarketOffer;
use App\Models\Market\TradeOffer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class TradeOfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'offer_type' => $this->getOfferableType(),
            'user' => PublicUserResource::make($this->getUser())->withoutItems(),
            'status' => Str::ucfirst($this->getResource()->status),
            'type' => Str::ucfirst($this->getResource()->type),
            'message' => $this->getResource()->message,
            'at_price' => $this->getResource()->at_price,
            'lat_price' => $this->getResource()->lat_price,
            'items' => TradeItemsResource::collection($this->getResource()->items),
        ];
    }

    private function getOfferableType(): string
    {
        return match ($this->getResource()->offerable_type) {
            MarketOffer::class => MarketOfferTypeEnum::MARKET_OFFER->value,
            User::class => MarketOfferTypeEnum::DIRECT->value,
            default => 'unknown',
        };
    }

    private function getResource(): TradeOffer
    {
        return $this->resource;
    }

    private function getUser(): User
    {

        return $this->getResource()->offerable instanceof User
            ? $this->getResource()->offerable
            : $this->getResource()->offerable->user;
    }
}
