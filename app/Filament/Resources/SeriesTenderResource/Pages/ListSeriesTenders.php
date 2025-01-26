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
      Actions\CreateAction::make()
        ->modalHeading(__('messages.create_series_tender'))
        ->modalSubmitActionLabel(__('messages.save'))
        ->createAnother(false)
        ->slideOver(),
    ];
  }
}
