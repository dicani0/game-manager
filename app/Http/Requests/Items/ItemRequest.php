<?php

namespace App\Http\Requests\Items;

use App\Models\Items\UserItem;
use Illuminate\Foundation\Http\FormRequest;

abstract class ItemRequest extends FormRequest
{
    public function getUserItem(): UserItem
    {
        return $this->route('item');
    }
}
