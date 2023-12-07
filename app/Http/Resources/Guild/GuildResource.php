<?php

namespace App\Http\Resources\Guild;

use App\Enums\GuildInvitationStatus;
use App\Models\Guild\Guild;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuildResource extends JsonResource
{
    private bool $includeInvitations = false;

    private bool $includeCharacters = true;

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
            $this->mergeWhen($this->includeCharacters, [
                'characters' => GuildCharacterResource::collection($this->getResource()->characters),
            ]),
            $this->mergeWhen($this->includeInvitations, [
                'invitations' => GuildInvitationResource::collection(
                    $this->getResource()->invitations->where('status', GuildInvitationStatus::PENDING)
                ),
            ]),
            'is_leader' => $this->getResource()->isLeader($request->user()),
            'is_vice_leader' => $this->getResource()->isViceLeader($request->user()),
        ];
    }

    public function withInvitations(): self
    {
        $this->includeInvitations = true;

        return $this;
    }

    public function withoutCharacters(): self
    {
        $this->includeCharacters = false;

        return $this;
    }

    public function getResource(): Guild
    {
        return $this->resource;
    }
}
