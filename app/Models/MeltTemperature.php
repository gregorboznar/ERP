<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeltTemperature extends Model
{
  use HasFactory;

  protected $fillable = ['temperature', 'recorded_at'];
}
