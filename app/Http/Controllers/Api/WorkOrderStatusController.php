<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use Illuminate\Http\Request;

class WorkOrderStatusController extends Controller
{
    /**
     * Get work order status data for selective DOM updates
     */
    public function getStatus(Request $request, $workOrderId)
    {
        try {
            $workOrder = WorkOrder::with('tracking')->findOrFail($workOrderId);

            $tracking = $workOrder->tracking->map(function ($status) {
                return [
                    'id' => $status->id,
                    'status_name' => $status->status_name,
                    'completed_at' => $status->completed_at,
                    'notes' => $status->notes,
                    'created_at' => $status->created_at,
                    'updated_at' => $status->updated_at,
                ];
            });

            return response()->json([
                'success' => true,
                'work_order' => [
                    'id' => $workOrder->id,
                    'wo_number' => $workOrder->wo_number,
                    'output' => $workOrder->output,
                    'status' => $workOrder->status,
                    'due_date' => $workOrder->due_date,
                    'completed_on' => $workOrder->completed_on,
                ],
                'tracking' => $tracking,
                'last_updated' => now()->toISOString(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific status data
     */
    public function getStatusById(Request $request, $workOrderId, $statusId)
    {
        try {
            $workOrder = WorkOrder::with('tracking')->findOrFail($workOrderId);
            $status = $workOrder->tracking()->findOrFail($statusId);

            return response()->json([
                'success' => true,
                'status' => [
                    'id' => $status->id,
                    'status_name' => $status->status_name,
                    'completed_at' => $status->completed_at,
                    'notes' => $status->notes,
                    'created_at' => $status->created_at,
                    'updated_at' => $status->updated_at,
                ],
                'last_updated' => now()->toISOString(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}






