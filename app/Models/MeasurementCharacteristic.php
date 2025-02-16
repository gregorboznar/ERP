<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeasurementCharacteristic extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'name',
    'unit',
    'nominal_value',
    'tolerance',
  ];

  protected $casts = [
    'nominal_value' => 'float',
    'tolerance' => 'float',
  ];
}
