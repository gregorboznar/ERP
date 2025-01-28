<?php

namespace App\Filament\Resources\MaintenancePointResource\Pages;

use App\Filament\Resources\MaintenancePointResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMaintenancePoint extends EditRecord
{
    protected static string $resource = MaintenancePointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
