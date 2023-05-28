<?php

namespace App\Http\Requests\Items;

use App\Models\UserItem;
use Illuminate\Foundation\Http\FormRequest;

abstract  class ItemRequest extends FormRequest
{
    public function getUserItem(): UserItem
    {
        return $this->route('item');
    }
}
