<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'machine_id',
    'activity_description',
    'lubrication_product',
    'frequency',
    'check_method',
  ];

  public function machine(): BelongsTo
  {
    return $this->belongsTo(Machine::class);
  }
}
