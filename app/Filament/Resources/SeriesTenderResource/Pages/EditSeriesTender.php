<?php

namespace App\Filament\Resources\SeriesTenderResource\Pages;

use App\Filament\Resources\SeriesTenderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSeriesTender extends EditRecord
{
  protected static string $resource = SeriesTenderResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\DeleteAction::make(),
    ];
  }
}
