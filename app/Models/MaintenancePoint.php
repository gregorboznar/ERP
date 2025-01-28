<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenancePoint extends Model
{
    protected $fillable = [
        'name',
        'description',
        'frequency',
        'last_check'
    ];

    protected $casts = [
        'last_check' => 'date'
    ];
}
