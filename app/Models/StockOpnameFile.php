<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpnameFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'original_name',
        'file_path',
        'file_size',
        'uploaded_by',
        'status', // 'uploaded', 'imported', 'deleted'
        'imported_at',
    ];

    protected $casts = [
        'imported_at' => 'datetime',
    ];

    public function stockOpnames()
    {
        return $this->hasMany(StockOpname::class, 'file_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}

