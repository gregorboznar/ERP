<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\ConfirmationComplianceMeasurementNestValue;

class ConfirmationCompliance extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'product_id',
    'series_tender_id',
    'user_id',
    'correct_technological_parameters',
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

  public function measurementNestValues(): HasMany
  {
    return $this->hasMany(ConfirmationComplianceMeasurementNestValue::class);
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
