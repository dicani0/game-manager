<?php

namespace App\Actions\Guild;

use App\Models\Guild\Guild;

class DeleteGuild
{
    public function handle(Guild $guild): void
    {
        $guild->delete();
    }
}