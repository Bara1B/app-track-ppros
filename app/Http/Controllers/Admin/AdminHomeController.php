<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use App\Models\WorkOrderTracking;
use App\Models\User;
use App\Models\Overmate;
use App\Models\StockOpnameFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminHomeController extends Controller
{
    public function index()
    {
        // Get real work order statistics
        $stats = [
            'total_wo' => WorkOrder::count(),
            'completed_wo' => WorkOrder::where('status', 'Completed')->count(),
            'ongoing_wo' => WorkOrder::where('status', 'On Progress')->count(),
            'total_users' => User::count(),
            'total_overmate' => Overmate::count(),
            'total_excel_files' => StockOpnameFile::where('status', '!=', 'deleted')->count(),
        ];

        return view('admin.home', compact('stats'));
    }
}
