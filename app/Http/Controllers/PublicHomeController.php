<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\WorkOrderTracking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PublicHomeController extends Controller
{
    public function index()
    {
        // Get public statistics (read-only)
        $totalWorkOrders = WorkOrder::count();

        // Completed = semua langkah tracking sudah completed_at (tidak ada yang null)
        $completedWorkOrders = WorkOrder::whereDoesntHave('tracking', function ($q) {
            $q->whereNull('completed_at');
        })->count();

        // Pending = belum selesai semua langkah
        $pendingWorkOrders = $totalWorkOrders - $completedWorkOrders;

        // Overdue = due date lewat dan BELUM completed
        $overdueWorkOrders = WorkOrder::where('due_date', '<', Carbon::now())
            ->whereHas('tracking', function ($q) {
                $q->whereNull('completed_at');
            })
            ->count();

        // Get recent work orders for public view (limit to 6)
        $recentWorkOrders = WorkOrder::with('tracking')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Get latest work order for tracking display
        $latestWorkOrder = WorkOrder::latest()->first();

        // Monthly WO Diterima counts for current year (12 months)
        $currentYear = Carbon::now()->year;
        $raw = WorkOrderTracking::selectRaw('MONTH(completed_at) as month, COUNT(*) as total')
            ->where('status_name', 'WO Diterima')
            ->whereYear('completed_at', $currentYear)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $monthlyWoAccepted = array_fill(0, 12, 0);
        foreach ($raw as $m => $count) {
            $index = max(1, (int)$m) - 1; // 0-based index
            $monthlyWoAccepted[$index] = (int)$count;
        }

        return view('public.home', compact(
            'totalWorkOrders',
            'pendingWorkOrders',
            'completedWorkOrders',
            'overdueWorkOrders',
            'recentWorkOrders',
            'latestWorkOrder',
            'monthlyWoAccepted'
        ));
    }

    /**
     * Show public tracking for a specific work order
     */
    public function showTracking(WorkOrder $workOrder)
    {
        // Load tracking data for public view
        $workOrder->load('tracking');

        return view('public.tracking', compact('workOrder'));
    }

    /**
     * Get public work orders list (read-only)
     */
    public function workOrders(Request $request)
    {
        $query = WorkOrder::with('tracking');

        // Filter by search term (WO number or output)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('wo_number', 'like', "%{$search}%")
                    ->orWhere('output', 'like', "%{$search}%")
                    ->orWhere('id_number', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->whereHas('tracking', function ($q) use ($request) {
                $q->where('status_name', $request->status);
            });
        }

        // Filter by completion status
        if ($request->filled('completion_status')) {
            if ($request->completion_status === 'completed') {
                $query->whereDoesntHave('tracking', function ($q) {
                    $q->whereNull('completed_at');
                });
            } elseif ($request->completion_status === 'pending') {
                $query->whereHas('tracking', function ($q) {
                    $q->whereNull('completed_at');
                });
            }
        }

        // Filter by due date range
        if ($request->filled('due_date_from')) {
            $query->where('due_date', '>=', $request->due_date_from);
        }
        if ($request->filled('due_date_to')) {
            $query->where('due_date', '<=', $request->due_date_to);
        }

        // Filter by overdue
        if ($request->filled('overdue') && $request->overdue === 'true') {
            $query->where('due_date', '<', Carbon::now())
                ->whereHas('tracking', function ($q) {
                    $q->whereNull('completed_at');
                });
        }

        $workOrders = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get available status options for filter
        $statusOptions = WorkOrderTracking::distinct('status_name')->pluck('status_name')->sort();

        // Get filter values for form persistence
        $filters = $request->only(['search', 'status', 'completion_status', 'due_date_from', 'due_date_to', 'overdue']);

        return view('public.work-orders', compact('workOrders', 'statusOptions', 'filters'));
    }
}
