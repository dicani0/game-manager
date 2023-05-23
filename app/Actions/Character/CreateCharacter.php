<?php

namespace App\Actions\Character;

use App\Data\Character\CharacterDto;
use App\Models\Character\Character;
use App\Models\User;

class CreateCharacter
{
    public function handle(CharacterDto $data, User $user)
    {
        Character::create($data->toArray() + ['user_id' => $user->getKey()]);
    }
}
