<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeasurementCharacteristic  extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'name',
    'unit',
    'nominal_value',
    'tolerance',
  ];



  public function products()
  {
    return $this->belongsToMany(Product::class, 'product_measurement_characteristics');
  }
}
