<?php

namespace App\Filament\Resources\MachinesResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\MachinesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMachines extends ListRecords
{
    protected static string $resource = MachinesResource::class;

    protected function getHeaderActions(): array
    {
        return [
             CreateAction::make()->label(__('messages.new_machine'))
                ->modalHeading(__('messages.new_machine'))
                ->modalDescription(__('messages.enter_details_for_new_machine'))
                ->modalWidth('xl')
                ->closeModalByClickingAway(true)
                ->createAnother(false)
                ->modalSubmitActionLabel(__('messages.save'))
                ->modalCancelActionLabel(__('messages.cancel')),
        ];
    }
}
