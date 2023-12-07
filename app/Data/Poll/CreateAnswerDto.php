<?php

namespace App\Data\Poll;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class CreateAnswerDto extends Data
{
    public function __construct(
        #[Required]
        public string $content
    ) {
    }
}
