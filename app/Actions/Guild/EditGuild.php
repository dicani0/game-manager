<?php

namespace App\Actions\Guild;

use App\Data\Guild\CreateGuildDto;
use App\Data\Guild\EditGuildDto;
use App\Models\Guild\Guild;

class EditGuild
{
    public function handle(EditGuildDto $dto): Guild
    {
        $dto->guild->update($dto->toArray());

        return $dto->guild->refresh();
    }
}