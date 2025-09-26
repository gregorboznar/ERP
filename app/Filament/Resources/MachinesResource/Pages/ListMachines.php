<?php

namespace App\Filament\Resources\MachinesResource\Pages;

use App\Filament\Resources\MachinesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMachines extends ListRecords
{
    protected static string $resource = MachinesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('messages.add_machine'))->icon('heroicon-m-plus'),
        ];
    }
}
