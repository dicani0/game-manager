<?php

namespace App\Actions\Guild;

use App\Data\Guild\CreateGuildDto;
use App\Models\Guild\Guild;

class CreateNewGuild
{
    public function handle(CreateGuildDto $dto): Guild
    {
        return Guild::create($dto->only('name', 'description', 'recruiting')->toArray());
    }
}
