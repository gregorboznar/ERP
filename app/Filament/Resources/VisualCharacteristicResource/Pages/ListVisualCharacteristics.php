<?php

namespace App\Filament\Resources\VisualCharacteristicResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\VisualCharacteristicResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVisualCharacteristics extends ListRecords
{
  protected static string $resource = VisualCharacteristicResource::class;

  protected function getHeaderActions(): array
  {
    return [
      CreateAction::make()
        ->label(__('messages.add_visual_characteristic'))->icon('heroicon-m-plus'),
    ];
  }
}
