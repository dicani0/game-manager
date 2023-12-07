<?php

namespace App\Actions\Items;

use App\Data\Items\ImportItemsDto;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ParseItemData
{
    public function handle(ImportItemsDto $dto, User $user): Collection
    {
        $lines = Str::of($dto->content)->explode("\n");

        return $lines->map(function ($line) use ($user) {
            $parts = Str::of($line)->trim()->explode('x', 2);
            $amount = Str::of(Arr::get($parts, 0))->trim();
            $name = Str::of(Arr::get($parts, 1))->before("\t")->before('-')->before('(P')->trim()->replace('Token', '');

            return [
                'amount' => $amount->toInteger(),
                'item_name' => $name->toString(),
                'user_id' => $user->getKey(),
            ];
        });
    }
}
