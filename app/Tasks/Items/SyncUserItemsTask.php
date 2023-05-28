<?php

namespace App\Tasks\Items;

use App\Actions\Items\SyncUserItems;
use App\Data\Items\ImportItemsDto;

readonly class SyncUserItemsTask
{
    public function __construct(
        private SyncUserItems $action,
    ) {
    }
    public function handle(ImportItemsDto $dto, \Closure $next): ImportItemsDto
    {
        $this->action->handle($dto);

        return $next($dto);
    }
}
