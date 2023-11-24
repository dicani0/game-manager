<?php

namespace App\Models\Character;

use App\Models\Guild\GuildCharacter;
use App\Models\Guild\GuildInvitation;
use App\Models\User;
use Database\Factories\Character\CharacterFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\Character\Character
 *
 * @property int                                   $id
 * @property string                                $name
 * @property string                                $vocation
 * @property int|null                              $guild_id
 * @property int                                   $user_id
 * @property Carbon|null                           $created_at
 * @property Carbon|null                           $updated_at
 * @property-read User                             $user
 * @method static Builder|Character newModelQuery()
 * @method static Builder|Character newQuery()
 * @method static Builder|Character query()
 * @method static Builder|Character whereCreatedAt($value)
 * @method static Builder|Character whereGuildId($value)
 * @method static Builder|Character whereId($value)
 * @method static Builder|Character whereName($value)
 * @method static Builder|Character whereUpdatedAt($value)
 * @method static Builder|Character whereUserId($value)
 * @method static Builder|Character whereVocation($value)
 * @property-read GuildCharacter|null              $guildCharacter
 * @property-read Collection<int, GuildInvitation> $guildInvitation
 * @property-read int|null                         $guild_invitation_count
 * @method static CharacterFactory factory($count = null, $state = [])
 * @mixin Eloquent
 */
class Character extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function guildCharacter(): HasOne
    {
        return $this->hasOne(GuildCharacter::class);
    }

    public function guildInvitation(): HasMany
    {
        return $this->hasMany(GuildInvitation::class);
    }
}
