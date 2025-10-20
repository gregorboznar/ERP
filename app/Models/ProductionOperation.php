<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductionOperation extends Model
{
  use HasFactory, SoftDeletes;

  protected $table = 'production_operations';

  protected $fillable = [
    'date',
    'start_time',
    'counter_start',
    'end_time',
    'counter_end',
    'good_parts_count',
    'technological_waste',
    'waste',
    'operation_type',
    'palet_number',
    'batch_of_material',
    'waste_slag_weight',
    'stopage_reason',
    'notes',
    'series_tender_id'
  ];

  protected $casts = [
    'date' => 'date',
    'start_time' => 'datetime',
    'end_time' => 'datetime',
    'counter_start' => 'integer',
    'counter_end' => 'integer',
    'good_parts_count' => 'integer',
    'technological_waste' => 'decimal:2',
    'waste' => 'decimal:2',
    'waste_slag_weight' => 'decimal:2'
  ];

  const TYPE_DIE_CASTING = 'die_casting';
  const TYPE_GRINDING = 'grinding';
  const TYPE_PACKAGING = 'packaging';
  const TYPE_MACHINE_TRIMMING = 'machine_trimming';
  const TYPE_TURNING_WASHING = 'turning_washing';


  public static function getOperationTypes(): array
  {
    return [
      self::TYPE_DIE_CASTING,
      self::TYPE_GRINDING,
      self::TYPE_PACKAGING,
      self::TYPE_MACHINE_TRIMMING,
      self::TYPE_TURNING_WASHING,
    ];
  }

  /**
   * Get operation type display name
   * 
   * @return string
   */
  public function getOperationTypeNameAttribute(): string
  {
    return match ($this->operation_type) {
      self::TYPE_DIE_CASTING => __('messages.die_castings'),
      self::TYPE_GRINDING => __('messages.grinding'),
      self::TYPE_PACKAGING => __('messages.packaging'),
      self::TYPE_MACHINE_TRIMMING => __('messages.machine_trimming'),
      self::TYPE_TURNING_WASHING => __('messages.turning_washing'),
      default => $this->operation_type,
    };
  }

  public function seriesTender()
  {
    return $this->belongsTo(SeriesTender::class);
  }

  // Scope to filter by operation type
  public function scopeOfType($query, $type)
  {
    return $query->where('operation_type', $type);
  }
}
