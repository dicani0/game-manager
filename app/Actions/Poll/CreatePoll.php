<?php

namespace App\Actions\Poll;

use App\Data\Poll\CreatePollDto;
use App\Models\Poll\Poll;

class CreatePoll
{
    public function handle(CreatePollDto $dto): Poll
    {
        return Poll::create($dto->only(
            'title',
            'description',
            'start_date',
            'end_date',
            'pollable_id',
            'pollable_type',
            'status',
        )->toArray());
    }
}
