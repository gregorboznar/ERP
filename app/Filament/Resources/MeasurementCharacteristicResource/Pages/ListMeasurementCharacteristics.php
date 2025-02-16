<?php

namespace App\Filament\Resources\MeasurementCharacteristicResource\Pages;

use App\Filament\Resources\MeasurementCharacteristicResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMeasurementCharacteristics extends ListRecords
{
  protected static string $resource = MeasurementCharacteristicResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }
}
