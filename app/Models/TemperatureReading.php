<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemperatureReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'melt_temperature_id',
        'temperature',
        'recorded_at'
    ];

    protected $casts = [
        'recorded_at' => 'datetime:H:i',
    ];

    public function meltTemperature()
    {
        return $this->belongsTo(MeltTemperature::class);
    }
}
