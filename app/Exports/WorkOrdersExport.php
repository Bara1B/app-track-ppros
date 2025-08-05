<?php

namespace App\Exports;

use App\Models\WorkOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class WorkOrdersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Ambil data WO bareng data tracking-nya biar sat set
        return WorkOrder::with('tracking')->latest()->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // Bikin heading dasar
        $baseHeadings = [
            'Nomor Work Order',
            'Nama Produk',
            'Due Date',
            'Status',
        ];

        // Bikin heading buat tiap step tracking
        $trackingSteps = [
            'WO Diterima',
            'Timbang',
            'Selesai Timbang',
            'Pengurangan Stock',
            'Released',
            'Kirim BB',
            'Selesai',
        ];

        // Gabungin semua heading jadi satu
        return array_merge($baseHeadings, $trackingSteps);
    }

    /**
     * @var WorkOrder $workOrder
     */
    public function map($workOrder): array
    {
        // Siapin data dasar buat tiap baris
        $baseData = [
            $workOrder->wo_number,
            $workOrder->output,
            $workOrder->due_date->format('d-m-Y'),
            $workOrder->status,
        ];

        // Bikin "kamus" buat nyimpen tanggal selesai tiap step
        // Biar gampang nyarinya
        $trackingDates = [];
        foreach ($workOrder->tracking as $track) {
            $trackingDates[$track->status_name] = $track->completed_at
                ? $track->completed_at->format('d-m-Y H:i')
                : '-'; // Kalo belom selesai, kasih strip
        }

        // Urutan step yang mau ditampilin (harus sama kayak di headings)
        $trackingSteps = [
            'WO Diterima', 'Timbang', 'Selesai Timbang', 'Pengurangan Stock',
            'Released', 'Kirim BB', 'Selesai',
        ];

        $rowData = $baseData;
        // Loop buat ngisi data tanggal tracking
        foreach ($trackingSteps as $step) {
            // Ambil tanggal dari "kamus", kalo ga ada, isi strip
            $rowData[] = $trackingDates[$step] ?? '-';
        }

        return $rowData;
    }
}
