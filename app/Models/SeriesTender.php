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
    'series_name',
    'company',
    'article',
    'tender_date'
  ];

  protected $casts = [
    'series_number' => 'integer',
    'tender_date' => 'date',
  ];
}
