<?php

namespace App\Http\Requests\Character;

use App\Enums\VocationEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreCharacterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:20'],
            'vocation' => ['required', new Enum(VocationEnum::class)],
        ];
    }
}
