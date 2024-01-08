<?php

namespace App\Policies\Poll;

use App\Enums\RoleEnum;
use App\Models\Guild\Guild;
use App\Models\Poll\Poll;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PollPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Poll $poll): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasRole(RoleEnum::ADMIN->value);
    }

    public function update(User $user, Poll $poll): bool
    {
        return $user->hasRole(RoleEnum::ADMIN->value) && $poll->creator_id === $user->getKey();
    }

    public function vote(User $user, Poll $poll): bool|Response
    {
        if (! $poll->is_active) {
            return $this->deny('This poll has not started yet.');
        }
        if ($poll->hasUserVoted($user)) {
            return $this->deny('You have already voted in this poll.');
        }

        if ($poll->pollable instanceof Guild) {
            if ($user->guilds->contains($poll->pollable)) {
                return true;
            } else {
                return $this->deny('You are not a member of this guild.');
            }
        }

        return true;
    }
}
