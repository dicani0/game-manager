<?php

namespace App\Models\Guild;

use App\Enums\GuildRoleEnum;
use App\Models\Character\Character;
use App\Models\Poll\Poll;
use App\Models\User;
use Database\Factories\Guild\GuildFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\GuildIndexQuery\GuildIndexQuery
 *
 * @property int                                   $id
 * @property string                                $name
 * @property string                                $description
 * @property int                                   $recruiting
 * @property string|null                           $logo
 * @property int                                   $level
 * @property int                                   $owner_id
 * @property Carbon|null                           $created_at
 * @property Carbon|null                           $updated_at
 * @property-read Collection<int, User>            $users
 * @property-read int|null                         $users_count
 * @method static Builder|Guild newModelQuery()
 * @method static Builder|Guild newQuery()
 * @method static Builder|Guild query()
 * @method static Builder|Guild whereCreatedAt($value)
 * @method static Builder|Guild whereDescription($value)
 * @method static Builder|Guild whereId($value)
 * @method static Builder|Guild whereLevel($value)
 * @method static Builder|Guild whereLogo($value)
 * @method static Builder|Guild whereName($value)
 * @method static Builder|Guild whereOwnerId($value)
 * @method static Builder|Guild whereRecruiting($value)
 * @method static Builder|Guild whereUpdatedAt($value)
 * @property-read Collection<int, Character>       $characters
 * @property-read int|null                         $characters_count
 * @property-read GuildCharacter|null              $leader
 * @property-read Collection<int, GuildInvitation> $invitations
 * @property-read int|null                         $invitations_count
 * @method static GuildFactory factory($count = null, $state = [])
 * @property-read Collection                       $vice_leaders
 * @mixin Eloquent
 */
class Guild extends Model
{
    use HasFactory, Prunable;

    const TABLE = 'guilds';
    protected $table = self::TABLE;

    protected $fillable = [
        'name',
        'description',
        'recruiting',
        'logo',
        'level',
        'owner_id',
    ];

    protected $casts = [
        'recruiting' => 'boolean',
    ];

    public function characters(): HasMany
    {
        return $this->hasMany(GuildCharacter::class);
    }

    public function getLeaderAttribute(): ?GuildCharacter
    {
        return $this->characters->where('role', GuildRoleEnum::LEADER)->first();
    }

    public function getViceLeadersAttribute(): Collection
    {
        return $this->characters->where('role', GuildRoleEnum::VICE_LEADER);
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(GuildInvitation::class);
    }

    public function isLeader(User $user): bool
    {
        $leader = $this->leader;

        if (!$leader) {
            return false;
        }

        return $user->characters->pluck('id')->contains($leader->character_id);
    }

    public function isViceLeader(User $user): bool
    {
        return $this->vice_leaders->contains(
            fn(GuildCharacter $character) => $user->characters->pluck('id')->contains($character->character_id)
        );
    }

    public function polls(): MorphMany
    {
        return $this->morphMany(Poll::class, 'pollable');
    }
}
