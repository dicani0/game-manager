<?php

namespace App\Enums;

use App\Enums\Trait\EnumExtras;

enum PollQuestionTypeEnum: string
{
    use EnumExtras;

    case SINGLE = 'single';
    case MULTIPLE = 'multiple';
}
