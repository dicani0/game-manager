<?php

namespace App\Http\Resources\Character;

use App\Models\Character\Character;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CharacterResource extends JsonResource
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
            'vocation' => $this->getResource()->vocation,
        ];
    }

    public function getResource(): Character
    {
        return $this->resource;
    }
}
