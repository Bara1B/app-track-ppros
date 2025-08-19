<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'file_id',
        'location_system',
        'item_number',
        'description',
        'manufacturer',
        'lot_serial',
        'reference',
        'quantity_on_hand',
        'stok_fisik',
        'unit_of_measure',
        'expired_date',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'expired_date' => 'date',
    ];

    public function file()
    {
        return $this->belongsTo(StockOpnameFile::class, 'file_id');
    }
}
