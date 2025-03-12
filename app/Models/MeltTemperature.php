<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MeltTemperature extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'machine_id',
    'product_id',
    'series_id',
    'temperature_readings'
  ];

  protected $casts = [
    'temperature_readings' => 'array',
  ];

  protected static function boot()
  {
    parent::boot();

    static::saving(function ($model) {
      if (Auth::check()) {
        $model->user_id = Auth::id();
      }
    });
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
