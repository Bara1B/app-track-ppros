<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserHomeController extends Controller
{
    public function index()
    {
        // Get statistics for the user
        $totalWorkOrders = WorkOrder::count();
        $pendingWorkOrders = WorkOrder::whereHas('tracking', function ($query) {
            $query->whereNull('completed_at');
        })->count();

        $completedWorkOrders = WorkOrder::whereHas('tracking', function ($query) {
            $query->whereNotNull('completed_at');
        })->count();

        $overdueWorkOrders = WorkOrder::where('due_date', '<', Carbon::now())->count();

        // Get recent work orders (limit to 6)
        $recentWorkOrders = WorkOrder::with('tracking')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Get latest work order for tracking button
        $latestWorkOrder = WorkOrder::latest()->first();

        return view('user.home', compact(
            'totalWorkOrders',
            'pendingWorkOrders',
            'completedWorkOrders',
            'overdueWorkOrders',
            'recentWorkOrders',
            'latestWorkOrder'
        ));
    }
}


