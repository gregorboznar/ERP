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
      $parts[] = $this->machine_type;
    }

    if ($this->manufacturer) {
      $parts[] = $this->manufacturer;
    }

    if ($this->year_of_manufacture) {
      $parts[] = "({$this->year_of_manufacture})";
    }

    if ($this->inventory_number) {
      $parts[] = "[{$this->inventory_number}]";
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

  protected $casts = [
    'year_of_manufacture' => 'integer',
    'control_period' => 'date',
  ];
}
