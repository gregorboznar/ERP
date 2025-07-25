<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MeltTemperature extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'machine_id',
    'product_id',
    'series_id'
  ];

  protected $casts = [
    'recorded_at' => 'datetime',
  ];

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      $model->user_id = Auth::id();
    });
  }

  protected $temperature_readings = [];

  public function getTemperatureReadingsAttribute()
  {
    return $this->temperature_readings;
  }

  public function temperatureReadings()
  {
    return $this->hasMany(TemperatureReading::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function machine()
  {
    return $this->belongsTo(Machine::class);
  }

  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  public function series()
  {
    return $this->belongsTo(SeriesTender::class);
  }
}
