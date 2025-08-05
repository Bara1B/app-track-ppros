<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // <--- TAMBAHKAN INI
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $work_order_id
 * @property string $status_name
 * @property string|null $completed_at
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\WorkOrder $workOrder
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderTracking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderTracking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderTracking query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderTracking whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderTracking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderTracking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderTracking whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderTracking whereStatusName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderTracking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderTracking whereWorkOrderId($value)
 * @mixin \Eloquent
 */
class WorkOrderTracking extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'completed_at' => 'datetime', // <-- TAMBAHIN BLOK INI, BRO
    ];

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }
}
