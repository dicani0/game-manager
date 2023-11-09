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
 * App\Models\Guild\GuildInvitation
 *
 * @property int            $id
 * @property int            $guild_id
 * @property int            $character_id
 * @property GuildRoleEnum  $role
 * @property Carbon|null    $created_at
 * @property Carbon|null    $updated_at
 * @property-read Character $character
 * @property-read Guild     $guild
 * @method static Builder|GuildInvitation newModelQuery()
 * @method static Builder|GuildInvitation newQuery()
 * @method static Builder|GuildInvitation query()
 * @method static Builder|GuildInvitation whereCharacterId($value)
 * @method static Builder|GuildInvitation whereCreatedAt($value)
 * @method static Builder|GuildInvitation whereGuildId($value)
 * @method static Builder|GuildInvitation whereId($value)
 * @method static Builder|GuildInvitation whereRole($value)
 * @method static Builder|GuildInvitation whereUpdatedAt($value)
 * @mixin Eloquent
 */
class GuildInvitation extends Model
{
    protected $fillable = [
        'guild_id',
        'character_id',
        'role',
    ];

    protected $casts = [
        'guild_id' => 'integer',
        'character_id' => 'integer',
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
