<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OvermateMaster extends Model
{
    protected $table = 'overmate_masters';

    protected $fillable = [
        'item_number',
        'nama_bahan',
        'manufacturer',
        'lot_serial',
        'overmate',
        'uom',
    ];
}
