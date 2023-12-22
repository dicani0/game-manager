<?php

namespace App\Data\Poll;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class PollVotingDto extends Data

{
    public
    function __construct()
    {
    }

    public
    static function authorize(): bool
    {
        return true;
    }

    public
    static function rules(ValidationContext $context): array
    {
        return [];
    }
}