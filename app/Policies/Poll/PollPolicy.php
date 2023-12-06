<?php

namespace App\Policies\Poll;

use App\Enums\RoleEnum;
use App\Models\Poll\Poll;
use App\Models\User;

class PollPolicy
{

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
        return $user->hasRole(RoleEnum::ADMIN->value);
    }
}
