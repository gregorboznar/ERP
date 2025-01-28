<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceCheck extends Model
{
    protected $fillable = [
        'date',
        'machine_id',
        'maintenance_point_id',
        'completed',
        'notes'
    ];

    public function machine(): BelongsTo
    {
        return $this->belongsTo(Machine::class);
    }

    public function maintenancePoint(): BelongsTo
    {
        return $this->belongsTo(MaintenancePoint::class);
    }
}
