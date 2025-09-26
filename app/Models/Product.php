<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'name',
    'nest_number',
    'nest_start_number',
    'code',
  ];


  public function seriesTenders()
  {
    return $this->hasMany(SeriesTender::class);
  }


  public function visualCharacteristics()
  {
    return $this->belongsToMany(VisualCharacteristic::class, 'product_visual_characteristics');
  }

  public function measurementCharacteristics()
  {
    return $this->belongsToMany(MeasurementCharacteristic::class, 'product_measurement_characteristics');
  }
}
