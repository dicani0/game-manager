<?php

namespace App\Enums;

use App\Enums\Trait\EnumExtras;

enum PollStatusEnum: string
{
    use EnumExtras;

    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case STARTED = 'started';
    case CLOSED = 'closed';

}
