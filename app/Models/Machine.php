<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Machine extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'machine_type',
    'type',
    'year_of_manufacture',
    'manufacturer',
    'control_period',
  ];

  protected $casts = [
    'year_of_manufacture' => 'integer',
    'control_period' => 'date',
  ];
}
