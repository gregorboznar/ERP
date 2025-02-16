<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'name',

  ];


  public function visualCharacteristics()
  {
    return $this->belongsToMany(VisualCharacteristic::class, 'product_visual_characteristic');
  }

  public function measurementCharacteristics()
  {
    return $this->belongsToMany(MeasurementCharacteristic::class, 'product_measurement_characteristic');
  }
}
