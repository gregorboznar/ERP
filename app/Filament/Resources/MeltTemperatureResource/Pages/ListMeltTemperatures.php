<?php

namespace App\Filament\Resources\MeltTemperatureResource\Pages;

use App\Filament\Resources\MeltTemperatureResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\MeltTemperatureResource\Widgets\MeltTemperatureChart;

class ListMeltTemperatures extends ListRecords
{
  protected static string $resource = MeltTemperatureResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make()->label(__('messages.create_new_melt_temperature'))
        ->icon('heroicon-m-plus')
        ->modalWidth('3xl')
        ->modalHeading(__('messages.create_new_melt_temperature'))
        ->modalDescription(__('messages.enter_details_for_new_melt_temperature'))
        ->closeModalByClickingAway(true)
        ->createAnother(false)
        ->modalSubmitActionLabel(__('messages.save'))
        ->modalCancelActionLabel(__('messages.cancel')),
    ];
  }

  protected function getHeaderWidgets(): array
  {
    return [
      MeltTemperatureChart::class,
    ];
  }
}
