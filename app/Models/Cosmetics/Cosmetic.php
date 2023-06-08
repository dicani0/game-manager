<?php

namespace App\Models\Cosmetics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Cosmetics\Cosmetic
 *
 * @property int $id
 * @property string $name
 * @property mixed|null $attributes
 * @property int $usable_amount
 * @method static \Illuminate\Database\Eloquent\Builder|Cosmetic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cosmetic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cosmetic query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cosmetic whereAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cosmetic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cosmetic whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cosmetic whereUsableAmount($value)
 * @method static \Database\Factories\Cosmetics\CosmeticFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class Cosmetic extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
}
