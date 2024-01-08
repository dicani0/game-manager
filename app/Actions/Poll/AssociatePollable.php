<?php

namespace App\Actions\Poll;

use App\Data\Poll\CreatePollDto;
use App\Models\Interfaces\Pollable;
use Exception;

class AssociatePollable
{
    /**
     * @throws Exception
     */
    public function handle(CreatePollDto $dto): void
    {
        $pollable_type = $dto->pollable_type;

        if (! class_exists($pollable_type)) {
            throw new Exception("Class {$pollable_type} does not exist");
        }

        /** @var Pollable $pollable */
        $pollable = $pollable_type::find($dto->pollable_id);

        $dto->poll->pollable()->associate($pollable);
        $dto->poll->save();
    }
}
