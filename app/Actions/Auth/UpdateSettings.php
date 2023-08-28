<?php

namespace App\Actions\Auth;

use App\Data\Auth\SettingsData;
use App\Models\User;

final class UpdateSettings
{
    public function handle(User $user, SettingsData $dto): void
    {
        $user->update($dto->toArray());
    }
}
