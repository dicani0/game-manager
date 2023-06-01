<?php

namespace App\Http\Resources\Cosmetics;

use App\Models\Cosmetics\Cosmetic;
use App\Models\Cosmetics\UserCosmetic;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CosmeticResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getResource()->getKey(),
            'name' => $this->getResource()->name,
            'attributes' => $this->getResource()->attributes,
            'usable_amount' => $this->getResource()->usable_amount,
            $this->mergeWhen(!is_null($request->user()), [
                'obtained' => $request->user()?->cosmetics->contains($this->getResource()),
                'obtained_amount' => $request->user()?->cosmetics->where('id', $this->getResource()->getKey())->first()?->pivot->amount
            ]),
        ];
    }

    private function getResource(): Cosmetic
    {
        return $this->resource;
    }
}
