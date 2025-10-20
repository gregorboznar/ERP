<?php

namespace App\Filament\Resources\MaintenancePointResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\MaintenancePointResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMaintenancePoint extends EditRecord
{
    protected static string $resource = MaintenancePointResource::class;



    public function getTitle(): string
    {
        return __('messages.edit_maintenance_point');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
