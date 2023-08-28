<?php

namespace App\Http\Requests\Auth;

class UpdateSettingsRequest extends SettingsRequest
{
    public function rules(): array
    {
        return [
            'discord_name' => ['nullable', 'string', 'max:255'],
            'private' => ['boolean'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }
}
