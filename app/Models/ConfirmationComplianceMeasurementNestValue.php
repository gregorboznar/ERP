<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfirmationComplianceMeasurementNestValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'confirmation_compliance_measurement_characteristic_id',
        'nest_number',
        'measured_value',
    ];

    public function measurementCharacteristic()
    {
        return $this->belongsTo(ConfirmationComplianceMeasurementCharacteristic::class);
    }
}
