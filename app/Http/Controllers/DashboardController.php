<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WorkOrdersExport;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = WorkOrder::query();

        // Filter berdasarkan pencarian (search)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('wo_number', 'like', "%{$search}%")
                    ->orWhere('output', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan status (On Progress / Completed)
        if ($request->filled('filter_status')) {
            $query->where('status', $request->filter_status);
        }

        // Filter berdasarkan Due Date
        if ($request->filled('filter_due')) {
            $today = now()->today();
            if ($request->filter_due == 'soon') {
                // Mendekati = dalam 7 hari ke depan
                $query->whereBetween('due_date', [$today, $today->copy()->addDays(7)]);
            } elseif ($request->filter_due == 'today') {
                $query->whereDate('due_date', $today);
            } elseif ($request->filter_due == 'overdue') {
                $query->where('due_date', '<', $today)->where('status', '!=', 'Completed');
            }
        }

        // Filter berdasarkan Hari Due Date
        if ($request->filled('filter_day')) {
            // MySQL: DAYOFWEEK() -> 1=Minggu, 2=Senin, ..., 7=Sabtu
            $days = [
                'senin' => 2, 'selasa' => 3, 'rabu' => 4,
                'kamis' => 5, 'jumat' => 6, 'sabtu' => 7, 'minggu' => 1
            ];
            if (array_key_exists($request->filter_day, $days)) {
                $query->whereRaw('DAYOFWEEK(due_date) = ?', [$days[$request->filter_day]]);
            }
        }

        $workOrders = $query->latest()->paginate(10)->withQueryString();

        return view('dashboard', compact('workOrders'));
    }

    /**
     * Handle export request.
     */
    public function export()
    {
        $fileName = 'work_orders_' . date('Y-m-d') . '.xlsx';
        return Excel::download(new WorkOrdersExport(), $fileName);
    }
}
