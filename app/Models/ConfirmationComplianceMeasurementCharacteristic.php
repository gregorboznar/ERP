<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConfirmationComplianceMeasurementCharacteristic extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'confirmation_compliance_id',
        'measurement_characteristic_id',
        'measured_value',
        'is_compliant',
        'notes',
    ];

    protected $casts = [
        'is_compliant' => 'boolean',
        'measured_value' => 'decimal:4',
    ];

    public function confirmationCompliance(): BelongsTo
    {
        return $this->belongsTo(ConfirmationCompliance::class);
    }

    public function measurementCharacteristic(): BelongsTo
    {
        return $this->belongsTo(MeasurementCharacteristic::class);
    }
}
