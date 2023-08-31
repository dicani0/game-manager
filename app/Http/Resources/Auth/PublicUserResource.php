<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\Items\UserItemResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicUserResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getKey(),
            'name' => $this->resource->name,
            'discord_name' => $this->resource->discord_name,
            'items' => UserItemResource::collection($this->resource->items),
        ];
    }
}
