<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Machine;

class MaintenancePoint extends Model
{
    protected $fillable = [
        'name',
        'description',
        'frequency'
    ];

    protected $casts = [
        'last_check' => 'date'
    ];

    public function machines()
    {
        return $this->belongsToMany(Machine::class, 'machine_maintenance_point')
            ->withTimestamps();
    }
}
