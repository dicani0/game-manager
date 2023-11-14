<?php

namespace App\Enums;

enum GuildInvitationStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case CANCELED = 'canceled';
}
