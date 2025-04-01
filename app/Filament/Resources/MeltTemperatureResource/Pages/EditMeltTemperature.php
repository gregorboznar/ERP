<?php

namespace App\Filament\Resources\MeltTemperatureResource\Pages;

use App\Filament\Resources\MeltTemperatureResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMeltTemperature extends EditRecord
{
  protected static string $resource = MeltTemperatureResource::class;

  public function getTitle(): string
  {
    return __('messages.edit_melt_temperature');
  }

  protected function getHeaderActions(): array
  {
    return [
      Actions\DeleteAction::make(),
    ];
  }
}
