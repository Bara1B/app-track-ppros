<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use App\Models\WorkOrderTracking;
use App\Models\User;
use App\Models\Overmate;
use App\Models\StockOpnameFile;
use App\Models\MasterProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminHomeController extends Controller
{
    public function index()
    {
        // Get real work order statistics
        $stats = [
            'total_master_work_order' => MasterProduct::count(), // Count master products from work-orders/data
            'total_wo' => WorkOrder::count(),
            'completed_wo' => WorkOrder::where('status', 'Completed')->count(),
            'ongoing_wo' => WorkOrder::where('status', 'On Progress')->count(),
            'on_progress_wo' => WorkOrder::where('status', 'On Progress')->count(), // Add alias for view compatibility
            'pending_wo' => WorkOrder::where('status', 'Pending')->count(),
            'overdue_wo' => WorkOrder::where('due_date', '<', now())
                ->whereNotIn('status', ['Completed'])->count(),
            'total_users' => User::count(),
            'total_overmate' => Overmate::count(),
            'total_excel_files' => StockOpnameFile::where('status', '!=', 'deleted')->count(),
        ];

        // Prepare chart data for donut chart - sesuai dengan card work order
        $chartLabels = [
            'Total Data Master Work Order',
            'Total Work Order',
            'Completed',
            'On Progress',
            'Overdue'
        ];
        $chartValues = [
            $stats['total_master_work_order'], // 256 - dari master_products
            $stats['total_wo'],                // 8 - dari work_orders
            $stats['completed_wo'],            // Completed work orders
            $stats['ongoing_wo'],              // On Progress work orders
            $stats['overdue_wo']               // Overdue work orders
        ];

        return view('admin.home', compact('stats', 'chartLabels', 'chartValues'));
    }
}
