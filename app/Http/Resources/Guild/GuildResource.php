<?php

namespace App\Http\Resources\Guild;

use App\Models\Guild\Guild;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuildResource extends JsonResource
{
    private bool $includeInvitations = false;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getResource()->id,
            'name' => $this->getResource()->name,
            'description' => $this->getResource()->description,
            'logo' => $this->getResource()->logo,
            'recruiting' => $this->getResource()->recruiting,
            'leader' => GuildCharacterResource::make($this->getResource()->leader),
            'characters' => GuildCharacterResource::collection($this->getResource()->characters),
            $this->mergeWhen($this->includeInvitations, [
                'invitations' => GuildInvitationResource::collection($this->getResource()->invitations),
            ]),
        ];
    }

    public function withInvitations(): self
    {
        $this->includeInvitations = true;

        return $this;
    }

    public function getResource(): Guild
    {
        return $this->resource;
    }
}
