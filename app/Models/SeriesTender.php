<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeriesTender extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'series_number',
    'company',
    'product_id',
    'tender_date',
    'series_size',
    'series_code'
  ];

  protected $casts = [
    'tender_date' => 'date',
  ];

  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  public function dieCastings()
  {
    return $this->hasMany(DieCasting::class);
  }

  public function packagings()
  {
    return $this->hasMany(Packagings::class);
  }
}
