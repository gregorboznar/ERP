<?php

namespace App\Filament\Resources\MeasurementCharacteristicResource\Pages;

use App\Filament\Resources\MeasurementCharacteristicResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMeasurementCharacteristic extends EditRecord
{
  protected static string $resource = MeasurementCharacteristicResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\DeleteAction::make(),
    ];
  }
}
