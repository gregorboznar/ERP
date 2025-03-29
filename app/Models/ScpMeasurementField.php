<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScpMeasurementField extends Model
{
    use HasFactory;

    protected $fillable = [
        'scp_measurement_id',
        'field_number',
        'measurement_value',
        'nest_number'
    ];

    public function measurement()
    {
        return $this->belongsTo(ScpMeasurement::class);
    }
}
