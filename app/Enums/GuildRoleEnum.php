<?php

namespace App\Enums;

enum GuildRoleEnum: string
{
    case LEADER = 'leader';
    const VICE_LEADER = 'vice_leader';
    const MEMBER = 'member';
}
