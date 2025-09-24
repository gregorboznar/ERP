<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Machine;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenancePoint extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'location'
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
