<?php

namespace App\Actions\Character;

use App\Data\Character\CharacterUpdateDto;
use App\Models\Character\Character;

class UpdateCharacter
{
    public function handle(Character $character, CharacterUpdateDto $data)
    {
        $character->update($data->toArray());
    }
}
