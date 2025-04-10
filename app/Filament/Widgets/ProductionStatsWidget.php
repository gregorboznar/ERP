<?php

namespace App\Filament\Widgets;

use App\Models\ProductionOperation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;

class ProductionStatsWidget extends BaseWidget
{
  protected static ?string $pollingInterval = null;
  protected static ?int $sort = 1;

  protected static bool $isLazy = false;

  public static function canView(): bool
  {

    return true;
  }

  protected static function getResource(): ?string
  {
    return null;
  }

  public ?Model $record = null;

  protected function getStats(): array
  {
    if (!$this->record) {
      return [];
    }


    $goodPartsByType = [];
    $totalWaste = 0;

    foreach (ProductionOperation::getOperationTypes() as $type) {
      $goodPartsByType[$type] = ProductionOperation::where('series_tender_id', $this->record->id)
        ->where('operation_type', $type)
        ->sum('good_parts_count');


      $wasteByType[$type] = ProductionOperation::where('series_tender_id', $this->record->id)
        ->where('operation_type', $type)
        ->sum('technological_waste') + ProductionOperation::where('series_tender_id', $this->record->id)
        ->where('operation_type', $type)
        ->sum('waste');

      $totalWaste += $wasteByType[$type];
    }

    $colors = [
      ProductionOperation::TYPE_DIE_CASTING => 'primary',
      ProductionOperation::TYPE_GRINDING => 'info',
      ProductionOperation::TYPE_PACKAGING => 'warning',
      ProductionOperation::TYPE_MACHINE_TRIMMING => 'success',
      ProductionOperation::TYPE_TURNING_WASHING => 'gray',
    ];

    $icons = [
      ProductionOperation::TYPE_DIE_CASTING => 'heroicon-m-rectangle-stack',
      ProductionOperation::TYPE_GRINDING => 'heroicon-m-adjustments-vertical',
      ProductionOperation::TYPE_PACKAGING => 'heroicon-m-archive-box',
      ProductionOperation::TYPE_MACHINE_TRIMMING => 'heroicon-m-cog',
      ProductionOperation::TYPE_TURNING_WASHING => 'heroicon-m-arrow-path',
    ];

    $stats = [];

    foreach (ProductionOperation::getOperationTypes() as $type) {
      if ($goodPartsByType[$type] > 0) {
        $stats[] = Stat::make(__(sprintf('messages.%s', $type)), number_format($goodPartsByType[$type]))
          ->description(__('messages.good_parts'))
          ->descriptionIcon($icons[$type] ?? 'heroicon-m-check-circle')
          ->color($colors[$type] ?? 'gray');
      }
    }

    if ($totalWaste > 0) {
      $stats[] = Stat::make(__('messages.waste'), number_format($totalWaste))
        ->description(__('messages.bad_parts'))
        ->descriptionIcon('heroicon-m-exclamation-triangle')
        ->color('danger');
    }

    return $stats;
  }


  protected function getColumns(): int
  {
    return 3;
  }
}
