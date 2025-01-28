<?php

namespace App\Filament\Resources\MaintenanceCheckResource\Pages;

use App\Filament\Resources\MaintenanceCheckResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMaintenanceCheck extends EditRecord
{
    protected static string $resource = MaintenanceCheckResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
