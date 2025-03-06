<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MeltTemperature extends Model
{
  use HasFactory;

  protected $fillable = ['temperature', 'recorded_at_1', 'recorded_at_2', 'recorded_at_3', 'recorded_at_4', 'user_id', 'machine_id', 'product_id', 'series_id', 'temperature_1', 'temperature_2', 'temperature_3', 'temperature_4'];

  protected $casts = [
    'recorded_at_1' => 'datetime',
    'recorded_at_2' => 'datetime',
    'recorded_at_3' => 'datetime',
    'recorded_at_4' => 'datetime',
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
