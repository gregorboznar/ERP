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
    'article',
    'tender_date'
  ];

  protected $casts = [
    'tender_date' => 'date',
  ];
}
