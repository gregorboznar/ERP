<?php

namespace App\Filament\Resources\ScpMeasurementResource\Pages;

use App\Filament\Resources\ScpMeasurementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditScpMeasurement extends EditRecord
{
    protected static string $resource = ScpMeasurementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
