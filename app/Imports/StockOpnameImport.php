<?php

namespace App\Imports;

use App\Models\StockOpname;
use App\Models\OvermateMaster;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Carbon\Carbon;

class StockOpnameImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    protected $fileId;

    public function __construct($fileId = null)
    {
        $this->fileId = $fileId;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Parse expired date - handle various date formats
        $expiredDate = null;
        $expireDateField = $row['expire_date'] ?? $row['expired_date'] ?? null;

        if (!empty($expireDateField)) {
            try {
                // Try various date formats
                if (is_numeric($expireDateField)) {
                    // Excel date serial
                    $expiredDate = Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($expireDateField - 2);
                } else {
                    // String date formats (dd/mm/yy format from screenshot)
                    if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{2})$/', $expireDateField, $matches)) {
                        $day = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
                        $month = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
                        $year = '20' . $matches[3]; // Assume 20xx for 2-digit years
                        $expiredDate = Carbon::createFromFormat('Y-m-d', "$year-$month-$day");
                    } else {
                        $expiredDate = Carbon::parse($expireDateField);
                    }
                }
            } catch (\Exception $e) {
                $expiredDate = null;
            }
        }

        // Handle both new format and old format columns
        $itemNumber = $row['item_number'] ?? '';
        $lotSerial  = $row['lotserial'] ?? $row['serial'] ?? '';

        // Sync manufacturer from Overmate master data when possible
        $manufacturer = '';
        if ($itemNumber) {
            $omQuery = OvermateMaster::where('item_number', $itemNumber);
            if ($lotSerial !== '') {
                $omQuery = $omQuery->where('lot_serial', $lotSerial);
            }
            $om = $omQuery->first();
            if (!$om) {
                // fallback by item only
                $om = OvermateMaster::where('item_number', $itemNumber)->first();
            }
            if ($om && !empty($om->manufacturer)) {
                $manufacturer = $om->manufacturer;
            }
        }

        return new StockOpname([
            'file_id' => $this->fileId,
            'location_system' => $row['location_system'] ?? $row['location_actual'] ?? '',
            'item_number' => $itemNumber,
            'description' => $row['description'] ?? '',
            'manufacturer' => $manufacturer,
            'lot_serial' => $lotSerial,
            'reference' => $row['reference'] ?? '',
            'quantity_on_hand' => (float) ($row['quantity_on_hand'] ?? 0),
            'stok_fisik' => !empty($row['stock_fisik']) ? (float) $row['stock_fisik'] : null,
            'unit_of_measure' => $row['um'] ?? $row['unit_of_measure'] ?? '',
            'expired_date' => $expiredDate,
        ]);
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
