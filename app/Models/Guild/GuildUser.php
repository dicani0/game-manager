<?php

namespace App\Models\Guild;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class GuildUser extends Pivot
{
    use HasFactory;
}
