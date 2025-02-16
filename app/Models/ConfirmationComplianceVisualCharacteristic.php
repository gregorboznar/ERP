<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConfirmationComplianceVisualCharacteristic extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'confirmation_compliance_id',
        'visual_characteristic_id',
        'is_compliant',
        'notes',
    ];

    protected $casts = [
        'is_compliant' => 'boolean',
    ];

    public function confirmationCompliance(): BelongsTo
    {
        return $this->belongsTo(ConfirmationCompliance::class);
    }

    public function visualCharacteristic(): BelongsTo
    {
        return $this->belongsTo(VisualCharacteristic::class);
    }
}
