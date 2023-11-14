<?php

namespace App\Policies;

use App\Enums\GuildInvitationStatus;
use App\Models\Guild\GuildInvitation;
use App\Models\User;

class GuildInvitationPolicy
{
    public function accept(User $user, GuildInvitation $invitation): bool
    {
        if ($invitation->status !== GuildInvitationStatus::PENDING) {
            return false;
        }

        if ($invitation->character->user_id !== $user->id) {
            return false;
        }

        return true;
    }

    public function reject(User $user, GuildInvitation $invitation): bool
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
