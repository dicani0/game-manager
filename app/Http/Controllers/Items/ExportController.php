<?php

namespace App\Http\Controllers\Items;

use App\Data\Items\ExportItemsDto;
use App\Exports\ItemsExport;
use App\Http\Controllers\Controller;
use Excel;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function exportItems(ExportItemsDto $dto): BinaryFileResponse
    {
        return Excel::download(
            new ItemsExport($dto->type),
            $dto->filename,
        );
    }
}
