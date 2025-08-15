<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // <--- TAMBAHKAN INI
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $wo_number
 * @property string|null $output
 * @property string $due_date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkOrderTracking> $tracking
 * @property-read int|null $tracking_count
 * @method static \Database\Factories\WorkOrderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereOutput($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereWoNumber($value)
 * @mixin \Eloquent
 */
class WorkOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'due_date' => 'date',
        'completed_on' => 'date', // <-- Tambahkan ini
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function tracking(): HasMany
    {
        return $this->hasMany(WorkOrderTracking::class)->orderBy('id');
    }

    public function woDiterimaTracking(): HasOne
    {
        return $this->hasOne(WorkOrderTracking::class)->where('status_name', 'WO Diterima');
    }

    public function masterProduct(): HasOne
    {
        return $this->hasOne(MasterProduct::class, 'description', 'output');
    }
}
