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
    'inventory_number',
    'control_period',
    'name',
  ];

  public function getName(): string
  {
    return $this->attributes['name'] ?? 'Unnamed Machine';
  }

  public function getNameAttribute(): string
  {
    return $this->getName();
  }

  public function getTitleAttribute($value)
  {
    return $value ?? $this->getName();
  }

  public function maintenancePoints()
  {
    return $this->belongsToMany(MaintenancePoint::class, 'machine_maintenance_point');
  }

  public function maintenanceChecks()
  {
    return $this->hasMany(MaintenanceCheck::class);
  }

  protected $casts = [
    'year_of_manufacture' => 'date',
    'control_period' => 'date',
  ];
}
