<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChartController extends Controller
{
    /**
     * Menyediakan data total Work Order per bulan untuk grafik.
     */
    public function monthlyWorkOrders()
    {
        // Ambil data dari database, hitung jumlah WO per bulan untuk tahun ini
        $data = WorkOrder::select(
            // ================================================ #
            //    DIKEMBALIKAN LAGI KE due_date, BRO            #
            // ================================================ #
            DB::raw('MONTH(due_date) as month'), // Diubah kembali ke due_date
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('due_date', now()->year) // Diubah kembali ke due_date
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
            'data' => array_values($chartData),
        ]);
    }
}
