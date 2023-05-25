<?php

namespace App\Http\Requests\Items;

use Illuminate\Foundation\Http\FormRequest;

class SyncItemsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'content' => 'required|string',
        ];
    }
}
