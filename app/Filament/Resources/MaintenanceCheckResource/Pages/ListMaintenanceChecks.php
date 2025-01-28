<?php

namespace App\Filament\Resources\MaintenanceCheckResource\Pages;

use App\Filament\Resources\MaintenanceCheckResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMaintenanceChecks extends ListRecords
{
    protected static string $resource = MaintenanceCheckResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('messages.new_maintenance_check'))
                ->modalHeading(__('messages.new_maintenance_check'))
                ->modalDescription(__('messages.enter_details_for_new_maintenance_check'))
                ->modalWidth('lg')
                ->closeModalByClickingAway(true)
                ->createAnother(false),
        ];
    }
}
