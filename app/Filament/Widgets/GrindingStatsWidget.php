<?php

namespace App\Filament\Widgets;

use App\Models\ProductionOperation;
use Filament\Support\Facades\FilamentView;
use App\Models\SeriesTender;
use Illuminate\Support\Facades\Log;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GrindingStatsWidget extends ProductionProcessStatsWidget
{
  protected static ?string $pollingInterval = null;
  protected static ?int $sort = 1;

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
    return ProductionOperation::TYPE_GRINDING;
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

    return $stats;
  }
}
