<?php

namespace App\Models\Guild;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\Guild\GuildUser
 *
 * @property int $id
 * @property int $guild_id
 * @property int $user_id
 * @property string $role
 * @property string $joined_at
 * @method static \Illuminate\Database\Eloquent\Builder|GuildUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GuildUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GuildUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|GuildUser whereGuildId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuildUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuildUser whereJoinedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuildUser whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuildUser whereUserId($value)
 * @mixin \Eloquent
 */
class GuildUser extends Pivot
{
    use HasFactory;
}
