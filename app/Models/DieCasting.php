<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DieCasting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'start_time',
        'counter_start',
        'end_time',
        'counter_end',
        'good_parts_count',
        'technological_waste',
        'batch_of_material',
        'palet_number',
        'waste_slag_weight',
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
        'waste_slag_weight' => 'decimal:2'
    ];

    public function seriesTender()
    {
        return $this->belongsTo(SeriesTender::class);
    }
}
