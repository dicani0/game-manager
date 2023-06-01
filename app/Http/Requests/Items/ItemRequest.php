<?php

namespace App\Http\Requests\Items;

use App\Models\Cosmetics\UserCosmetic;
use Illuminate\Foundation\Http\FormRequest;

abstract  class ItemRequest extends FormRequest
{
    public function getUserItem(): UserCosmetic
    {
        return $this->route('item');
    }
}
