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

  public function getChartData()
  {
    $readings = $this->temperatureReadings()
      ->orderBy('recorded_at')
      ->get();

    if ($readings->isEmpty()) {
      return [
        'id' => $this->id,
        'labels' => [],
        'values' => []
      ];
    }

    return [
      'id' => $this->id,
      'labels' => $readings->map(function ($reading) {
        return $reading->recorded_at->format('H:i');
      })->toArray(),
      'values' => $readings->pluck('temperature')->toArray()
    ];
  }
}
