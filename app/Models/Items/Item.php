<?php

namespace App\Models\Items;

use Database\Factories\Items\ItemFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Items\Item
 *
 * @method static Builder|Item newModelQuery()
 * @method static Builder|Item newQuery()
 * @method static Builder|Item query()
 * @property int $id
 * @property string $name
 * @property mixed|null $attributes
 * @property int $usable_amount
 * @method static ItemFactory factory($count = null, $state = [])
 * @method static Builder|Item whereAttributes($value)
 * @method static Builder|Item whereId($value)
 * @method static Builder|Item whereName($value)
 * @method static Builder|Item whereUsableAmount($value)
 * @mixin \Eloquent
 */
class Item extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
}
