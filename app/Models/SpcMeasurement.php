<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SpcMeasurement extends Model
{
    protected $fillable = ['measurement_name', 'value', 'tolerance_min', 'tolerance_max'];
}
