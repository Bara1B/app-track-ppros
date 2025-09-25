<?php

namespace App\Exports;

/**
 * Stock Opname Filled Export
 * 
 * @noinspection PhpUndefinedClassInspection
 * @noinspection PhpUndefinedNamespaceInspection
 * @noinspection PhpUndefinedMethodInspection
 */

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

/**
 * Stock Opname Filled Export
 * 
 * @implements FromQuery
 * @implements WithMapping
 * @implements WithHeadings
 * @implements WithColumnWidths
 * @implements WithStyles
 */
class StockOpnameFilledExport implements FromQuery, WithMapping, WithHeadings, WithColumnWidths, WithStyles
{
    protected int $fileId;

    public function __construct(int $fileId)
    {
        $this->fileId = $fileId;
    }

    public function query(): Builder
    {
        return DB::table('stock_opnames as so')
            ->leftJoin('overmate_masters as omm', function ($join) {
                $join->on('omm.item_number', '=', 'so.item_number')
                    ->on('omm.lot_serial', '=', 'so.lot_serial');
            })
            ->leftJoin('overmate as om', 'om.item_number', '=', 'so.item_number')
            ->where('so.file_id', $this->fileId)
            ->orderBy('so.id', 'asc')
            ->select([
                'so.location_system',
                'so.item_number',
                'so.description',
                'so.unit_of_measure',
                'so.lot_serial',
                'so.reference',
                'so.quantity_on_hand',
                'so.expired_date',
                'so.stok_fisik',
                DB::raw('COALESCE(omm.overmate, om.overmate_qty) as overmate_value'),
            ]);
    }

    public function map($r): array
    {
        $masuk = '';
        $selisih = null;
        if (!is_null($r->stok_fisik) && !is_null($r->quantity_on_hand)) {
            $selisih = (float)$r->stok_fisik - (float)$r->quantity_on_hand;
            $overmate = (float)($r->overmate_value ?? 0);
            $masuk = ($selisih <= $overmate) ? 'YA' : 'Tidak';
        }

        $expire = '';
        if (!empty($r->expired_date)) {
            try {
                $expire = date('d/m/y', strtotime($r->expired_date));
            } catch (\Throwable $th) {
                $expire = (string) $r->expired_date;
            }
        }

        // Row number will be auto (Excel doesn't know idx here). Keep blank or compute outside.
        // We'll keep No empty; user can add numbering in Excel if needed, or we can compute via a counter state if required.
        // To keep consistent visually, we can leave it blank.
        return [
            '', // No (left blank for performance without state)
            $r->location_system,
            '✓', // Location Actual: always checkmark
            $r->item_number,
            $r->description,
            $r->unit_of_measure,
            $r->lot_serial,
            $r->reference,
            round((float)$r->quantity_on_hand, 5),
            $expire,
            is_null($r->stok_fisik) ? '' : round((float)$r->stok_fisik, 5),
            is_null($selisih) ? '' : round((float)$selisih, 5),
            is_null($r->overmate_value) ? '' : round((float)$r->overmate_value, 5),
            $masuk,
            '', // Keterangan (empty, for user input)
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Location System',
            'Location Actual',
            'Item Number',
            'Description',
            'UM',
            'Lot/Serial',
            'Reference',
            'Quantity On Hand',
            'Expire Date',
            'Stock Fisik',
            'Selisih',
            'Overmate',
            'Masuk',
            'Keterangan',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 15,
            'C' => 15,
            'D' => 12,
            'E' => 25,
            'F' => 8,
            'G' => 15,
            'H' => 12,
            'I' => 15,
            'J' => 12,
            'K' => 12,
            'L' => 12,
            'M' => 12,
            'N' => 10,
            'O' => 20,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '4472C4']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            ],
            // Center the Location Actual column
            'C:C' => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            ],
        ];
    }
}
