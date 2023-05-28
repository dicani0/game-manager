<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_name',
        'amount',
        'available_amount',
        'used_amount',
        'sold_amount',
    ];

    public function getAvailableAmountAttribute()
    {
        return $this->amount - $this->used_amount - $this->sold_amount;
    }
}
