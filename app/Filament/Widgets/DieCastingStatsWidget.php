<?php

namespace App\Filament\Widgets;

use App\Models\ProductionOperation;
use Filament\Support\Facades\FilamentView;
use App\Models\SeriesTender;
use Illuminate\Support\Facades\Log;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DieCastingStatsWidget extends ProductionProcessStatsWidget
{
  protected ?string $pollingInterval = null;
  protected static ?int $sort = 1;
  protected static bool $isLazy = false;

  public static function canView(): bool
  {
    return true;
  }

  public function mount(?SeriesTender $record = null): void
  {
    $this->record = $record;
  }

  public static function shouldWidgetBeRenderedOnDashboard(): bool
  {
    // Only show on specific pages, not on the dashboard
    return false;
  }

  protected function getOperationType(): string
  {
    return ProductionOperation::TYPE_DIE_CASTING;
  }

  protected function getStats(): array
  {
    if (!$this->record || !$this->record->exists) {
      return [
        Stat::make(__('messages.no_data'), '-')
          ->description(__('messages.no_series_found'))
          ->descriptionIcon('heroicon-m-x-circle')
          ->color('gray')
      ];
    }

    // Get parent stats first
    $stats = parent::getStats();

    // Check if we have a "no data" message in the stats
    if (empty($stats) || (isset($stats[0]) && str_contains(json_encode($stats[0]), 'no_data'))) {
      return $stats;
    }

    // Get die casting specific stats
    $operations = ProductionOperation::query()
      ->where('operation_type', ProductionOperation::TYPE_DIE_CASTING)
      ->where('series_tender_id', $this->record->id)
      ->withoutTrashed()
      ->get();

    $totalWasteSlagWeight = $operations->sum('waste_slag_weight');

    if ($totalWasteSlagWeight > 0) {
      $stats[] = Stat::make(
        __('messages.waste_slag_weight'),
        number_format($totalWasteSlagWeight, 2)
      )
        ->description(__('messages.total_waste_slag_weight'))
        ->descriptionIcon('heroicon-m-scale')
        ->color('danger');
    }

    return $stats;
  }
}
