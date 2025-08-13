<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WorkOrdersExport;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request, $status = 'On Progress')
    {
        // Jika yang login adalah pengguna biasa, berikan dasbor khusus
        if (Auth::user()->role == 'user') {
            if (!in_array($status, ['On Progress', 'Completed'])) {
                $status = 'On Progress';
            }

            $query = WorkOrder::with(['woDiterimaTracking', 'tracking'])->where('status', $status);

            // Filter berdasarkan pencarian
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('wo_number', 'like', "%{$search}%")
                        ->orWhere('output', 'like', "%{$search}%");
                });
            }

            // Logika pengurutan dari dropdown
            if ($request->filled('sort_by')) {
                $sortParts = explode('-', $request->sort_by);
                $sortBy = $sortParts[0];
                $sortDirection = $sortParts[1] ?? 'asc';

                $allowedSorts = ['output', 'due_date', 'created_at'];
                if (in_array($sortBy, $allowedSorts)) {
                    if ($sortBy === 'due_date') {
                        $query->orderBy('due_date', $sortDirection)
                            ->orderBy('wo_number', 'asc'); // Urutan kedua
                    } else {
                        $query->orderBy($sortBy, $sortDirection);
                    }
                }
            } else {
                $query->latest('created_at'); // Default sort: yang terbaru dibuat
            }

            $workOrders = $query->paginate(9)->withQueryString();
            return view('user.dashboard', compact('workOrders', 'status'));
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
        return view('dashboard', compact('workOrders'));
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
        ];

        // Kirim data statistik ke view
        return view('admin.home', compact('stats'));
    }
}
