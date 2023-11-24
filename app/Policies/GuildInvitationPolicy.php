<?php

namespace App\Policies;

use App\Enums\GuildInvitationStatus;
use App\Models\Guild\GuildInvitation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class GuildInvitationPolicy
{
    use HandlesAuthorization;

    public function accept(User $user, GuildInvitation $invitation): true|Response
    {
        if (!empty($invitation->character->guildCharacter)) {
            return $this->deny('This character is already in a guild.');
        }

        if ($invitation->character->user_id !== $user->getKey()) {
            return $this->deny('You do not own this character.');
        }

        if ($invitation->status !== GuildInvitationStatus::PENDING) {
            return $this->deny('This invitation is no longer valid.');
        }

        return true;
    }

    public function reject(User $user, GuildInvitation $invitation): true|Response
    {
        return $this->accept($user, $invitation);
    }

    public function cancel(User $user, GuildInvitation $invitation): bool
    {
        return $invitation->status === GuildInvitationStatus::PENDING && (
                $invitation->guild->isLeader($user) || $invitation->guild->isViceLeader($user)
            );
    }
}
