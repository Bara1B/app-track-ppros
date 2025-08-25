<?php

namespace App\Imports;

use App\Models\WorkOrder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;
use Illuminate\Support\Collection;

class WorkOrdersImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts, SkipsOnFailure, SkipsOnError
{
    use Importable;

    public function collection(Collection $rows)
    {
        // Normalize and bulk upsert per chunk
        $now = now();
        $upserts = [];

        foreach ($rows as $row) {
            $wo = trim((string)($row['wo_number'] ?? $row['wo'] ?? ''));
            if ($wo === '') {
                continue; // skip empty
            }

            $output = trim((string)($row['output'] ?? '')) ?: null;
            $status = trim((string)($row['status'] ?? '')) ?: null;
            $dueRaw = $row['due_date'] ?? $row['due'] ?? null;
            $completedRaw = $row['completed_on'] ?? $row['completed_date'] ?? null;

            $due = $this->parseDate($dueRaw);
            $completed = $this->parseDate($completedRaw);

            $upserts[] = [
                'wo_number' => $wo,
                'output' => $output,
                'due_date' => $due,
                'status' => $status,
                'completed_on' => $completed,
                'updated_at' => $now,
                'created_at' => $now,
            ];
        }

        if (!empty($upserts)) {
            // Upsert on wo_number (unique key recommended)
            WorkOrder::upsert($upserts, ['wo_number'], ['output', 'due_date', 'status', 'completed_on', 'updated_at']);
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function onFailure(...$failures)
    {
        // You may log or collect failures if needed
        Log::warning('WorkOrdersImport failures', ['count' => count($failures)]);
    }

    public function onError(\Throwable $e)
    {
        Log::error('WorkOrdersImport error', ['error' => $e->getMessage()]);
    }

    private function parseDate($value)
    {
        if (is_null($value) || $value === '') return null;
        // Excel numeric date
        if (is_numeric($value)) {
            try {
                return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value))->format('Y-m-d');
            } catch (\Throwable $e) {
                // fall through
            }
        }
        // Try common string formats
        try {
            return Carbon::parse((string)$value)->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
    }
}
