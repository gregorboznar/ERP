<?php

namespace App\Filament\Resources\ScpMeasurementResource\Pages;

use App\Filament\Resources\ScpMeasurementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListScpMeasurements extends ListRecords
{
    protected static string $resource = ScpMeasurementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
