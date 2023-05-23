<?php

namespace App\Http\Requests\Character;

use App\Enums\VocationEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Enum;

class UpdateCharacterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('edit', $this->route('character'));
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'vocation' => ['required', new Enum(VocationEnum::class)],
        ];
    }
}
