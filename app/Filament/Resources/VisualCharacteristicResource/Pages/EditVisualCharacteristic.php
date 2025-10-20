<?php

namespace App\Filament\Resources\VisualCharacteristicResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\VisualCharacteristicResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVisualCharacteristic extends EditRecord
{
  protected static string $resource = VisualCharacteristicResource::class;

  protected function getHeaderActions(): array
  {
    return [
      DeleteAction::make(),
    ];
  }
}
