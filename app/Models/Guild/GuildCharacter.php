<?php

namespace App\Models\Guild;

use App\Enums\GuildRoleEnum;
use App\Models\Character\Character;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Guild\GuildCharacter
 *
 * @property int            $id
 * @property int            $guild_id
 * @property int            $character_id
 * @property GuildRoleEnum  $role
 * @property Carbon|null    $created_at
 * @property Carbon|null    $updated_at
 * @property-read Character $character
 * @property-read Guild     $guild
 *
 * @method static Builder|GuildCharacter newModelQuery()
 * @method static Builder|GuildCharacter newQuery()
 * @method static Builder|GuildCharacter query()
 * @method static Builder|GuildCharacter whereCharacterId($value)
 * @method static Builder|GuildCharacter whereCreatedAt($value)
 * @method static Builder|GuildCharacter whereGuildId($value)
 * @method static Builder|GuildCharacter whereId($value)
 * @method static Builder|GuildCharacter whereRole($value)
 * @method static Builder|GuildCharacter whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class GuildCharacter extends Model
{
    public $timestamps = true;

    protected $table = 'guild_character';

    protected $fillable = [
        'guild_id',
        'character_id',
        'role',
    ];

    protected $casts = [
        'role' => GuildRoleEnum::class,
    ];

    public function guild(): BelongsTo
    {
        return $this->belongsTo(Guild::class);
    }

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }
}
