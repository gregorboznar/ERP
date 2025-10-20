<?php

namespace App\Filament\Widgets;

use App\Models\ProductionOperation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;
use App\Models\SeriesTender;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

abstract class ProductionProcessStatsWidget extends BaseWidget
{
  protected ?string $pollingInterval = null;
  protected static ?int $sort = 1;
  protected static bool $isLazy = false;

  public static function canView(): bool
  {
    return true;
  }

  protected static bool $canViewWidget = false;

  public ?SeriesTender $record = null;

  public function mount(): void
  {
    // Get the parent Livewire component (page)
    $page = $this->getParentComponent();

    if ($page && property_exists($page, 'record')) {
      $seriesTenderId = $page->record;

      if ($seriesTenderId) {
        $this->record = SeriesTender::find($seriesTenderId);
        Log::info('Found record', ['id' => $seriesTenderId, 'exists' => $this->record ? true : false]);
      }
    }
  }

  public static function shouldWidgetBeRenderedOnDashboard(): bool
  {

    return false;
  }

  abstract protected function getOperationType(): string;

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

    $operationType = $this->getOperationType();

    // Get stats for this specific operation type and series
    $operations = ProductionOperation::where('operation_type', $operationType)
      ->where('series_tender_id', $this->record->id)
      ->withoutTrashed()
      ->orderBy('date', 'desc')
      ->orderBy('start_time', 'desc')
      ->get();
    /* 
    if ($operations->isEmpty()) {
      return [
        Stat::make(__('messages.no_data'), '-')
          ->description(__('messages.no_operations_found'))
          ->descriptionIcon('heroicon-m-x-circle')
          ->color('gray')
      ];
    }
 */
  
    $totalGoodParts = $operations->sum('good_parts_count');

  
    $totalWaste = $operations->sum('waste');

   
    $totalTechWaste = $operations->sum('technological_waste');

    $icons = [
      ProductionOperation::TYPE_DIE_CASTING => 'heroicon-m-rectangle-stack',
      ProductionOperation::TYPE_GRINDING => 'heroicon-m-adjustments-vertical',
      ProductionOperation::TYPE_PACKAGING => 'heroicon-m-archive-box',
      ProductionOperation::TYPE_MACHINE_TRIMMING => 'heroicon-m-cog',
      ProductionOperation::TYPE_TURNING_WASHING => 'heroicon-m-arrow-path',
    ];

    $colors = [
      ProductionOperation::TYPE_DIE_CASTING => 'primary',
      ProductionOperation::TYPE_GRINDING => 'info',
      ProductionOperation::TYPE_PACKAGING => 'warning',
      ProductionOperation::TYPE_MACHINE_TRIMMING => 'success',
      ProductionOperation::TYPE_TURNING_WASHING => 'gray',
    ];

    $icon = $icons[$operationType] ?? 'heroicon-m-check-circle';
    $color = $colors[$operationType] ?? 'gray';

    // Return the statistics
    $stats = [
      Stat::make(__('messages.good_parts_count'), number_format($totalGoodParts))
        ->description(__('messages.total_good_parts'))
        ->descriptionIcon($icon)
        ->color($color),

      Stat::make(__('messages.waste'), number_format($totalWaste + $totalTechWaste, 2))
        ->description(__('messages.waste') . ' + ' . __('messages.technological_waste'))
        ->descriptionIcon('heroicon-m-exclamation-triangle')
        ->color('danger'),
    ];

    $firstOperation = $operations->last();
    $lastOperation = $operations->first();

    if ($firstOperation && $lastOperation && $firstOperation->date && $lastOperation->date) {
      $startDate = Carbon::parse($firstOperation->date)->format('d.m');
      $endDate = Carbon::parse($lastOperation->date)->format('d.m');

      $stats[] = Stat::make(
        __('messages.date_range'),
        $startDate . ' - ' . $endDate
      )
        ->description(__('messages.operation_period'))
        ->descriptionIcon('heroicon-m-calendar')
        ->color($color);
    }

    return $stats;
  }

  protected function getColumns(): int
  {
    return 3;
  }
}
