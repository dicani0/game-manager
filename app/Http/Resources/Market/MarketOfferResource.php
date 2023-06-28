<?php

namespace App\Http\Resources\Market;

use App\Models\Market\MarketOffer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MarketOfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

        ];
    }

    private function getResource(): MarketOffer
    {
        return $this->resource;
    }
}
