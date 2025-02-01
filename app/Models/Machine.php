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
    'title',

  ];

  public function getName(): string
  {
    $parts = [];

    if ($this->machine_type) {
    }



    return implode(' - ', array_filter($parts)) ?: 'Unnamed Machine';
  }

  public function getNameAttribute(): string
  {
    return $this->getName();
  }

  public function getTitleAttribute($value): string
  {
    return $value ?? $this->getName();
  }

  public function maintenancePoints()
  {
    return $this->belongsToMany(MaintenancePoint::class, 'machine_maintenance_point')
        ->withTimestamps();
  }

  protected $casts = [
    'year_of_manufacture' => 'integer',
    'control_period' => 'date',
  ];
}
