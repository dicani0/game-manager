<?php

namespace App\Actions\Poll;

use App\Data\Poll\UpdatePollDto;

class UpdatePoll
{
    public function handle(UpdatePollDto $dto): void
    {
        $dto->poll->update($dto->only(
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
