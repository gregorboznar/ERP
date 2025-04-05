<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Packagings extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'packagings';

    protected $fillable = [
        'date',
        'start_time',
        'counter_start',
        'end_time',
        'counter_end',
        'good_parts_count',
        'technological_waste',
        'waste',
        'palet_number',
        'stopage_reason',
        'notes',
        'series_tender_id'
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'counter_start' => 'integer',
        'counter_end' => 'integer',
        'good_parts_count' => 'integer',
        'technological_waste' => 'decimal:2',
        'waste' => 'decimal:2'
    ];

    public function seriesTender()
    {
        return $this->belongsTo(SeriesTender::class);
    }
}
