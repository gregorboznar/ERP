<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConfirmationCompliance extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'product_id',
  ];

  public function product(): BelongsTo
  {
    return $this->belongsTo(Product::class);
  }

  public function visualCharacteristics(): HasMany
  {
    return $this->hasMany(ConfirmationComplianceVisualCharacteristic::class);
  }

  public function measurementCharacteristics(): HasMany
  {
    return $this->hasMany(ConfirmationComplianceMeasurementCharacteristic::class);
  }
}
