<?php

namespace App\Http\Requests\Items;

class DeleteItemRequest extends ItemRequest
{
    public function authorize(): bool
    {
        return $this->getUserItem()->user_id === $this->user()->getKey();
    }

    public function rules(): array
    {
        return [];
    }
}
