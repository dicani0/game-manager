<?php

namespace App\Enums;

use App\Enums\Trait\EnumExtras;

enum GuildRoleEnum: string
{
    use EnumExtras;

    case LEADER = 'leader';
    case VICE_LEADER = 'vice_leader';
    case MEMBER = 'member';
}
