<?php

namespace App\Filament\Resources\DieCastingResource\Pages;

use App\Filament\Resources\DieCastingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDieCasting extends EditRecord
{
    protected static string $resource = DieCastingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
