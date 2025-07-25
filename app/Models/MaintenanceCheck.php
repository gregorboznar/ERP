<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MaintenanceCheck extends Model
{
    protected $fillable = [
        'date',
        'machine_id',
        'completed',
        'notes'
    ];

    public function machine(): BelongsTo
    {
        return $this->belongsTo(Machine::class);
    }

    public function maintenancePoints(): BelongsToMany
    {
        return $this->belongsToMany(MaintenancePoint::class, 'maintenance_check_points')
            ->withPivot('checked')
            ->withTimestamps();
    }
}
