<?php

namespace App\Filament\Resources\SeriesTenderResource\Pages;

use App\Filament\Resources\SeriesTenderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSeriesTenders extends ListRecords
{
  protected static string $resource = SeriesTenderResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make()->label(__('messages.new_series_tender'))
        ->modalHeading(__('messages.new_series_tender'))
        ->modalDescription(__('messages.enter_details_for_new_series_tender'))
        ->modalWidth('lg')
        ->closeModalByClickingAway(true)
        ->createAnother(false)
        ->modalSubmitActionLabel(__('messages.save'))
        ->modalCancelActionLabel(__('messages.cancel')),
    ];
  }
}
