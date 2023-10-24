<?php

namespace App\Models\Guild;

use App\Enums\GuildRoleEnum;
use App\Models\Character\Character;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuildCharacter extends Model
{
    protected $table = 'guild_character';

    protected $fillable = [
        'guild_id',
        'character_id',
        'role',
    ];

    protected $casts = [
        'role' => GuildRoleEnum::class,
    ];

    public $timestamps = false;

    public function guild(): BelongsTo
    {
        return $this->belongsTo(Guild::class);
    }

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }
}
