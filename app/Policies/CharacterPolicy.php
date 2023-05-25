<?php

namespace App\Policies;

use App\Models\Character\Character;
use App\Models\User;

class CharacterPolicy
{
    public function edit(User $user, Character $character): bool
    {
        return $this->isOwner($user, $character);
    }

    public function delete(User $user, Character $character): bool
    {
        return $this->isOwner($user, $character);
    }

    private function isOwner(User $user, Character $character): bool
    {
        return $user->getKey() === $character->user_id;
    }
}
