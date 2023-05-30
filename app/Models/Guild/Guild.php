<?php

namespace App\Models\Guild;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Guild\Guild
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $recruiting
 * @property string|null $logo
 * @property int $level
 * @property int $owner_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Guild newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Guild newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Guild query()
 * @method static \Illuminate\Database\Eloquent\Builder|Guild whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guild whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guild whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guild whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guild whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guild whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guild whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guild whereRecruiting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guild whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Guild extends Model
{
    use HasFactory;
    const TABLE = 'guilds';
    protected $table = self::TABLE;

    public function users(): HasMany
    {
        return $this->hasMany(User::class)->using(GuildUser::class);
    }
}
