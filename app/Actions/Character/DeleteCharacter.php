<?php

namespace App\Actions\Character;

use App\Data\Character\CharacterDto;
use App\Models\Character\Character;
use App\Models\User;

class DeleteCharacter
{
    public function handle(User $user, Character $character)
    {
        $user->characters()->whereKey($character->getKey())->delete();
    }
}
