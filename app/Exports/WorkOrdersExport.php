<?php

namespace App\Exports;

use App\Models\WorkOrder;
use App\Models\WorkOrderTracking;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;

class WorkOrdersExport implements FromView, ShouldAutoSize, WithEvents
{
    protected ?int $month;
    protected ?int $year;
    protected ?array $ids;

    public function __construct(?int $month = null, ?int $year = null, ?array $ids = null)
    {
        $this->month = $month;
        $this->year = $year;
        $this->ids = $ids;
    }

    protected function query(): Collection
    {
        $query = WorkOrder::with(['tracking', 'masterProduct']);

        if (!empty($this->ids)) {
            return $query->whereIn('id', $this->ids)->latest()->get();
        }

        if ($this->month && $this->year) {
            $workOrderIds = WorkOrderTracking::where('status_name', 'WO Diterima')
                ->whereMonth('completed_at', $this->month)
                ->whereYear('completed_at', $this->year)
                ->pluck('work_order_id')
                ->toArray();
            $query->whereIn('id', $workOrderIds);
        }

        return $query->latest()->get();
    }

    public function view(): View
    {
        $rows = $this->query();

        $exportMonth = Carbon::createFromDate(
            $this->year ?? now()->year,
            $this->month ?? now()->month,
            1
        )->locale('id');

        $titleMonth = $exportMonth->isoFormat('MMMM'); // hanya bulan

        return view('exports.work_orders', [
            'rows' => $rows,
            'titleMonth' => $titleMonth,
            'total' => $rows->count(),
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Tebalkan judul dan tengah
                $sheet = $event->sheet->getDelegate();
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A2')->getFont()->setBold(true);
            },
        ];
    }
}
