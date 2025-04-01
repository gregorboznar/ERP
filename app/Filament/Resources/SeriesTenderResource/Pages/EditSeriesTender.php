<?php

namespace App\Filament\Resources\SeriesTenderResource\Pages;

use App\Filament\Resources\SeriesTenderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSeriesTender extends EditRecord
{
  protected static string $resource = SeriesTenderResource::class;

  public function getTitle(): string
  {
    return __('messages.edit_series_tender');
  }

  protected function getHeaderActions(): array


  {
    return [
      Actions\DeleteAction::make(),
    ];
  }
}
