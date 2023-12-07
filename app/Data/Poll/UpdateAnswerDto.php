<?php

namespace App\Data\Poll;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class UpdateAnswerDto extends Data
{
    public function __construct(
        #[Required]
        public string       $content,
        public int|Optional $id,
    )
    {
    }
}