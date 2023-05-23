<?php

namespace App\Actions\Character;

use App\Data\Character\CharacterDto;
use App\Models\Character\Character;

class UpdateCharacter
{
    public function handle(Character $character, CharacterDto $data)
    {
        $character->update($data->toArray());
    }
}
