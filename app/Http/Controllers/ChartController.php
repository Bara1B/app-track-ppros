<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\WorkOrderTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChartController extends Controller
{
    /**
     * Menyediakan data total Work Order DITERIMA per bulan (berdasarkan tracking 'WO Diterima').
     */
    public function monthlyWorkOrders()
    {
        // Hitung jumlah WO Diterima per bulan di tahun berjalan berdasarkan completed_at pada step 'WO Diterima'
        $data = WorkOrderTracking::select(
                DB::raw('MONTH(completed_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('status_name', 'WO Diterima')
            ->whereYear('completed_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->all();

        // Siapkan array untuk 12 bulan, isi dengan 0 jika tidak ada data
        $chartData = [];
        for ($m = 1; $m <= 12; $m++) {
            $chartData[$m] = $data[$m] ?? 0;
        }

        // Buat label nama bulan dalam Bahasa Indonesia
        $monthLabels = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthLabels[] = Carbon::create()->month($m)->translatedFormat('F');
        }

        // Kirim data dalam format JSON yang siap digunakan oleh Chart.js
        return response()->json([
            'labels' => $monthLabels,
            'values' => array_values($chartData), // Changed from 'data' to 'values' to match frontend expectation
        ]);
    }
}
