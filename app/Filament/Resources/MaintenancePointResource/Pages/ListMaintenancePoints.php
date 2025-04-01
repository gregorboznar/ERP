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
            Actions\CreateAction::make()->label(__('messages.new_maintenance_point'))
                ->modalHeading(__('messages.new_maintenance_point'))
                ->modalDescription(__('messages.enter_details_for_new_maintenance_point'))
                ->modalWidth('2xl')
                ->closeModalByClickingAway(true)
                ->createAnother(false)
                ->modalSubmitActionLabel(__('messages.save'))
                ->modalCancelActionLabel(__('messages.cancel')),
        ];
    }
}
