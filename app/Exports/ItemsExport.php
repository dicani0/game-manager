<?php

namespace App\Exports;

use App\Enums\ExportTypeEnum;
use App\Models\Items\Item;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ItemsExport implements FromCollection, ShouldAutoSize, WithEvents, WithHeadings, WithStyles
{
    private Collection $data;

    public function __construct(private readonly ExportTypeEnum $type)
    {
        $query = Auth::user();

        $query = match (true) {
            $this->type === ExportTypeEnum::SELLABLE => $query->sellableItems(),
            default => $query->items(),
        };

        $query->orderByPivot('amount', 'desc');

        $this->data = $query->get();
    }

    public function prepareRows(array $rows): array
    {
        return Arr::map($rows, function (Item $item) {
            return [
                'name' => $item->name,
                'amount' => $item->pivot->amount,
                'tier' => $item->tier,
                'power' => $item->power,
                'attributes' => $item->attributes ? json_encode(Arr::mapWithKeys($item->attributes, function (?array $value) {
                    return [$value['name'] => $value['value']];
                }), JSON_UNESCAPED_SLASHES) : null,
            ];
        });
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Amount',
            'Tier',
            'Power',
            'Attributes',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => 'center',
                ],
            ],
            'B1' => [
                'font' => [
                    'italic' => true,
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $count = $this->data->count();

                for ($row = 2; $row <= $count + 1; $row++) {
                    $cell = $event->sheet->getCell('B' . $row);

                    if ($cell->getValue() > 1) {
                        $event->sheet->getStyle('A' . $row)->getFill()->setFillType('solid')->getStartColor()->setARGB('FF00FF00');
                        $event->sheet->getStyle('B' . $row)->getFill()->setFillType('solid')->getStartColor()->setARGB('FF00FF00');
                    }
                }
            },
        ];
    }
}
