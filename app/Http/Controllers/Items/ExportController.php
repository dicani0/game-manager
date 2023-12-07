<?php

namespace App\Http\Controllers\Items;

use App\Exports\ItemsExport;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function exportItems(Request $request): BinaryFileResponse
    {
        return Excel::download(
            new ItemsExport(request('type', ItemsExport::SELLABLE)),
            'items.xlsx'
        );
    }
}
