<?php

namespace App\Tasks\Items;

use App\Actions\Items\ParseItemData;
use App\Data\Items\ImportItemsDto;
use Closure;

readonly class ParseItemsTask
{
    public function __construct(
        private ParseItemData $action,
    ) {
    }

    public function handle(ImportItemsDto $dto, Closure $next): ImportItemsDto
    {
        $dto->items = $this->action->handle($dto, $dto->user);

        return $next($dto);
    }
}
