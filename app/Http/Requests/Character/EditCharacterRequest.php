<?php

namespace App\Http\Requests\Character;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class EditCharacterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('edit', $this->route('character'));
    }

    public function rules(): array
    {
        return [];
    }
}
