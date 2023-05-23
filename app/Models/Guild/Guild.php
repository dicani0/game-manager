<?php

namespace App\Models\Guild;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
