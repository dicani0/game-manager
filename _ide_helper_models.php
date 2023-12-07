<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models\Character{
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
	class Character extends \Eloquent {}
}

namespace App\Models\Guild{
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
	class Guild extends \Eloquent {}
}

namespace App\Models\Guild{
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
 * @method static Builder|GuildCharacter newModelQuery()
 * @method static Builder|GuildCharacter newQuery()
 * @method static Builder|GuildCharacter query()
 * @method static Builder|GuildCharacter whereCharacterId($value)
 * @method static Builder|GuildCharacter whereCreatedAt($value)
 * @method static Builder|GuildCharacter whereGuildId($value)
 * @method static Builder|GuildCharacter whereId($value)
 * @method static Builder|GuildCharacter whereRole($value)
 * @method static Builder|GuildCharacter whereUpdatedAt($value)
 * @mixin Eloquent
 */
	class GuildCharacter extends \Eloquent {}
}

namespace App\Models\Guild{
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
 * @property GuildInvitationStatus $status
 * @method static Builder|GuildInvitation whereStatus($value)
 * @mixin Eloquent
 */
	class GuildInvitation extends \Eloquent {}
}

namespace App\Models\Items{
/**
 * App\Models\Items\Item
 *
 * @method static Builder|Item newModelQuery()
 * @method static Builder|Item newQuery()
 * @method static Builder|Item query()
 * @property int        $id
 * @property string     $name
 * @property mixed|null $attributes
 * @property int        $usable_amount
 * @method static ItemFactory factory($count = null, $state = [])
 * @method static Builder|Item whereAttributes($value)
 * @method static Builder|Item whereId($value)
 * @method static Builder|Item whereName($value)
 * @method static Builder|Item whereUsableAmount($value)
 * @property int        $tier
 * @property int        $power
 * @method static Builder|Item wherePower($value)
 * @method static Builder|Item whereTier($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $users
 * @property-read int|null $users_count
 * @mixin Eloquent
 */
	class Item extends \Eloquent {}
}

namespace App\Models\Items{
/**
 * App\Models\Items\UserItem
 *
 * @property-read int                    $available_amount
 * @method static Builder|UserItem newModelQuery()
 * @method static Builder|UserItem newQuery()
 * @method static Builder|UserItem query()
 * @property int                         $id
 * @property int                         $user_id
 * @property int                         $item_id
 * @property int                         $amount
 * @property int                         $used_amount
 * @property int                         $sold_amount
 * @property int                         $reserved_amount
 * @property int                         $bought_amount
 * @property Carbon|null                 $created_at
 * @property Carbon|null                 $updated_at
 * @method static UserItemFactory factory($count = null, $state = [])
 * @method static Builder|UserItem whereAmount($value)
 * @method static Builder|UserItem whereBoughtAmount($value)
 * @method static Builder|UserItem whereCreatedAt($value)
 * @method static Builder|UserItem whereId($value)
 * @method static Builder|UserItem whereItemId($value)
 * @method static Builder|UserItem whereReservedAmount($value)
 * @method static Builder|UserItem whereSoldAmount($value)
 * @method static Builder|UserItem whereUpdatedAt($value)
 * @method static Builder|UserItem whereUsedAmount($value)
 * @method static Builder|UserItem whereUserId($value)
 * @property-read Item $item
 * @property-read User $user
 * @mixin Eloquent
 */
	class UserItem extends \Eloquent {}
}

namespace App\Models\Market{
/**
 * App\Models\Market\MarketOffer
 *
 * @property int                                   $id
 * @property int                                   $user_id
 * @property string                                $type
 * @property string                                $expires_at
 * @property int                                   $promoted
 * @property int|null                              $at_price
 * @property int|null                              $lat_price
 * @property string|null                           $description
 * @property string                                $status
 * @property Carbon|null                           $created_at
 * @property Carbon|null                           $updated_at
 * @property-read Collection<int, MarketOfferItem> $items
 * @property-read int|null                         $items_count
 * @property-read Collection<int, TradeOffer>      $offers
 * @property-read int|null                         $offers_count
 * @property-read User                             $user
 * @method static MarketOfferFactory factory($count = null, $state = [])
 * @method static Builder|MarketOffer maxAtPrice(int $value)
 * @method static Builder|MarketOffer maxLatPrice(int $value)
 * @method static Builder|MarketOffer newModelQuery()
 * @method static Builder|MarketOffer newQuery()
 * @method static Builder|MarketOffer query()
 * @method static Builder|MarketOffer whereAtPrice($value)
 * @method static Builder|MarketOffer whereCreatedAt($value)
 * @method static Builder|MarketOffer whereDescription($value)
 * @method static Builder|MarketOffer whereExpiresAt($value)
 * @method static Builder|MarketOffer whereId($value)
 * @method static Builder|MarketOffer whereLatPrice($value)
 * @method static Builder|MarketOffer wherePromoted($value)
 * @method static Builder|MarketOffer whereStatus($value)
 * @method static Builder|MarketOffer whereType($value)
 * @method static Builder|MarketOffer whereUpdatedAt($value)
 * @method static Builder|MarketOffer whereUserId($value)
 * @mixin Eloquent
 */
	class MarketOffer extends \Eloquent implements \App\Models\Interfaces\Offerable {}
}

namespace App\Models\Market{
/**
 * App\Models\Market\MarketOfferItem
 *
 * @property int $id
 * @property int $market_offer_id
 * @property int $cosmetic_id
 * @property int $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Item $cosmetic
 * @property-read \App\Models\Market\MarketOffer|null $offer
 * @method static Builder|MarketOfferItem newModelQuery()
 * @method static Builder|MarketOfferItem newQuery()
 * @method static Builder|MarketOfferItem query()
 * @method static Builder|MarketOfferItem whereAmount($value)
 * @method static Builder|MarketOfferItem whereCosmeticId($value)
 * @method static Builder|MarketOfferItem whereCreatedAt($value)
 * @method static Builder|MarketOfferItem whereId($value)
 * @method static Builder|MarketOfferItem whereMarketOfferId($value)
 * @method static Builder|MarketOfferItem whereUpdatedAt($value)
 * @property int $item_id
 * @property-read Item $item
 * @method static Builder|MarketOfferItem whereItemId($value)
 * @mixin \Eloquent
 */
	class MarketOfferItem extends \Eloquent {}
}

namespace App\Models\Market{
/**
 * App\Models\Market\TradeOffer
 *
 * @property-read User                  $creator
 * @property-read Collection<int, Item> $items
 * @property-read int|null              $items_count
 * @property-read Model|Eloquent        $offerable
 * @method static Builder|TradeOffer newModelQuery()
 * @method static Builder|TradeOffer newQuery()
 * @method static Builder|TradeOffer query()
 * @property int                        $id
 * @property string                     $offerable_type
 * @property int                        $offerable_id
 * @property int                        $user_id
 * @property int|null                   $at_price
 * @property int|null                   $lat_price
 * @property string                     $status
 * @property string                     $type
 * @property string|null                $message
 * @property Carbon|null                $created_at
 * @property Carbon|null                $updated_at
 * @method static Builder|TradeOffer whereAtPrice($value)
 * @method static Builder|TradeOffer whereCreatedAt($value)
 * @method static Builder|TradeOffer whereId($value)
 * @method static Builder|TradeOffer whereLatPrice($value)
 * @method static Builder|TradeOffer whereMessage($value)
 * @method static Builder|TradeOffer whereOfferableId($value)
 * @method static Builder|TradeOffer whereOfferableType($value)
 * @method static Builder|TradeOffer whereStatus($value)
 * @method static Builder|TradeOffer whereType($value)
 * @method static Builder|TradeOffer whereUpdatedAt($value)
 * @method static Builder|TradeOffer whereUserId($value)
 * @mixin Eloquent
 * @mixin \Eloquent
 */
	class TradeOffer extends \Eloquent {}
}

namespace App\Models{
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
 * @property int                                                            $private
 * @method static Builder|User wherePrivate($value)
 * @property-read Collection<int, TradeOffer>                               $offers
 * @property-read int|null                                                  $offers_count
 * @property-read Collection $guilds
 * @mixin Eloquent
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail, \App\Models\Interfaces\Offerable {}
}

