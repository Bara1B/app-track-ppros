<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\User;
use App\Models\Overmate;
use App\Models\StockOpnameFile;
use App\Models\MasterProduct;
use App\Models\StockOpname;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WorkOrdersExport;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request, $status = 'On Progress')
    {
        // Pengguna biasa tidak lagi memiliki halaman user: arahkan ke public home
        if (Auth::user()->role == 'user') {
            return redirect()->route('public.home');
        }

        // Logika untuk admin
        $query = WorkOrder::with('woDiterimaTracking');

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('wo_number', 'like', "%{$search}%")
                    ->orWhere('output', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan status
        if ($request->filled('filter_status')) {
            $query->where('status', $request->filter_status);
        }

        // Filter berdasarkan jatuh tempo
        if ($request->filled('filter_due')) {
            $today = now()->today();
            if ($request->filter_due == 'soon') {
                $query->whereBetween('due_date', [$today, $today->copy()->addDays(7)]);
            } elseif ($request->filter_due == 'today') {
                $query->whereDate('due_date', $today);
            } elseif ($request->filter_due == 'overdue') {
                $query->where('due_date', '<', $today)->where('status', '!=', 'Completed');
            }
        }

        // Filter berdasarkan bulan jatuh tempo
        if ($request->filled('filter_month')) {
            $query->whereRaw('MONTH(due_date) = ?', [$request->filter_month]);
        }

        // Logika pengurutan
        $sortBy = $request->query('sort_by', 'created_at');
        $sortDirection = $request->query('sort_direction', 'desc');
        $allowedSorts = ['wo_number', 'output', 'due_date', 'status', 'created_at', 'wo_diterima_date'];

        if (in_array($sortBy, $allowedSorts)) {
            if ($sortBy === 'wo_diterima_date') {
                $query->select('work_orders.*', 'trackings.completed_at as wo_diterima_completed_at')
                    ->leftJoin('work_order_trackings as trackings', function ($join) {
                        $join->on('work_orders.id', '=', 'trackings.work_order_id')
                            ->where('trackings.status_name', '=', 'WO Diterima');
                    })
                    ->orderBy('wo_diterima_completed_at', $sortDirection);
            } else {
                $query->orderBy($sortBy, $sortDirection);
            }
        }

        $workOrders = $query->paginate(10)->withQueryString();
        
        // Statistics for dashboard cards
        $totalWorkOrders = WorkOrder::count();
        $pendingWorkOrders = WorkOrder::where('status', 'On Progress')->count();
        $completedWorkOrders = WorkOrder::where('status', 'Completed')->count();
        $overdueWorkOrders = WorkOrder::where('due_date', '<', now()->today())
            ->where('status', '!=', 'Completed')
            ->count();

        // Completed (Late): WO berstatus Completed namun selesai setelah due_date
        $completedLateWorkOrders = WorkOrder::where('status', 'Completed')
            ->where(function ($q) {
                // Case 1: field completed_on ada dan melewati due_date
                $q->whereColumn('completed_on', '>', 'due_date')
                    // Case 2: completed_on null, gunakan completed_at terakhir dari tracking yang melewati due_date
                    ->orWhere(function ($q2) {
                        $q2->whereNull('completed_on')
                            ->whereExists(function ($sub) {
                                $sub->select(DB::raw(1))
                                    ->from('work_order_trackings as t')
                                    ->whereColumn('t.work_order_id', 'work_orders.id')
                                    ->whereNotNull('t.completed_at')
                                    ->orderByDesc('t.completed_at')
                                    ->limit(1)
                                    ->whereColumn('t.completed_at', '>', 'work_orders.due_date');
                            });
                    });
            })
            ->count();
        
        return view('workorderdashboard', compact(
            'workOrders',
            'totalWorkOrders',
            'pendingWorkOrders',
            'completedWorkOrders',
            'overdueWorkOrders',
            'completedLateWorkOrders'
        ));
    }

    /**
     * Menangani permintaan ekspor.
     */
    public function export(Request $request)
    {
        $request->validate([
            'month' => 'nullable|integer|between:1,12',
            'year'  => 'nullable|integer|min:2000',
            'ids'   => 'nullable|array'
        ]);

        $ids = $request->query('ids');
        $month = $request->query('month');
        $year = $request->query('year');

        // Jika user memilih bulan tapi tidak memilih tahun, gunakan tahun berjalan
        if ($month && !$year) {
            $year = now()->year;
        }

        $fileName = 'work_orders_' . date('Y-m-d') . '.xlsx';

        return Excel::download(new WorkOrdersExport($month, $year, $ids), $fileName);
    }

    public function home()
    {
        // Menyiapkan data untuk kartu statistik
        $stats = [
            'total_wo' => WorkOrder::count(),
            'on_progress_wo' => WorkOrder::where('status', 'On Progress')->count(),
            'completed_wo' => WorkOrder::where('status', 'Completed')->count(),
            'total_users' => User::count(),
            'total_overmate' => Overmate::count(),
            'total_excel_files' => StockOpnameFile::where('status', '!=', 'deleted')->count(),
            // Tambahan untuk ringkasan donut chart
            'total_master_work_order' => MasterProduct::count(),
            'total_stock_opname' => StockOpname::count(),
        ];

        // Kirim data statistik ke view
        return view('admin.home', compact('stats'));
    }
}
