<?php

namespace App\Models;

use App\Models\Character\Character;
use App\Models\Guild\Guild;
use App\Models\Interfaces\Offerable as OfferableInterface;
use App\Models\Items\Item;
use App\Models\Items\UserItem;
use App\Models\Market\MarketOffer;
use App\Models\Market\TradeOffer;
use App\Traits\Offerable;
use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User
 *
 * @property int                                                            $id
 * @property string                                                         $name
 * @property string                                                         $email
 * @property Carbon|null                                                    $email_verified_at
 * @property string                                                         $password
 * @property string|null                                                    $discord_name
 * @property string|null                                                    $remember_token
 * @property Carbon|null                                                    $created_at
 * @property Carbon|null                                                    $updated_at
 * @property int                                                            $available_promotes
 * @property-read Collection<int, Character>                                $characters
 * @property-read int|null                                                  $characters_count
 * @property-read Guild                                                     $guild
 * @property-read Collection<int, Item>                                     $items
 * @property-read int|null                                                  $items_count
 * @property-read Collection<int, MarketOffer>                              $marketOffers
 * @property-read int|null                                                  $market_offers_count
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null                                                  $notifications_count
 * @property-read Collection<int, Permission>                               $permissions
 * @property-read int|null                                                  $permissions_count
 * @property-read Collection<int, Role>                                     $roles
 * @property-read int|null                                                  $roles_count
 * @property-read Collection<int, PersonalAccessToken>                      $tokens
 * @property-read int|null                                                  $tokens_count
 *
 * @method static UserFactory factory($count = null, $state = [])
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User permission($permissions)
 * @method static Builder|User query()
 * @method static Builder|User role($roles, $guard = null)
 * @method static Builder|User whereAvailablePromotes($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereDiscordName($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 *
 * @property int                                                            $private
 *
 * @method static Builder|User wherePrivate($value)
 *
 * @property-read Collection<int, TradeOffer>                               $offers
 * @property-read int|null                                                  $offers_count
 * @property-read Collection                                                $guilds
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Item> $sellableItems
 * @property-read int|null $sellable_items_count
 *
 * @mixin Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail, OfferableInterface
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable, Offerable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'discord_name',
        'private',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function characters(): HasMany
    {
        return $this->hasMany(Character::class);
    }

    /**
     * @return BelongsToMany<Item>
     */
    public function items(): BelongsToMany
    {
        return $this
            ->belongsToMany(Item::class, 'user_item')
            ->using(UserItem::class)
            ->withPivot(['id', 'amount', 'used_amount', 'sold_amount', 'reserved_amount', 'bought_amount']);
    }

    public function sellableItems(): BelongsToMany
    {
        return $this
            ->belongsToMany(Item::class, 'user_item')
            ->using(UserItem::class)
            ->withPivot(['id', 'amount', 'used_amount', 'sold_amount', 'reserved_amount', 'bought_amount'])
            ->wherePivot('amount', '>', 1);
    }

    public function getGuildsAttribute(): Collection
    {
        return $this->characters->pluck('guildCharacter')->filter()->pluck('guild')->unique('id');
    }

    public function marketOffers(): HasMany
    {
        return $this->hasMany(MarketOffer::class);
    }
}
