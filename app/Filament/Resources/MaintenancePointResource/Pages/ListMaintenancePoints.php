<?php

namespace App\Filament\Resources\MaintenancePointResource\Pages;

use App\Filament\Resources\MaintenancePointResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMaintenancePoints extends ListRecords
{
    protected static string $resource = MaintenancePointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
