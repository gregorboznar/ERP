<?php

namespace App\Filament\Resources\MachinesResource\Pages;

use App\Filament\Resources\MachinesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMachines extends CreateRecord
{
    protected static string $resource = MachinesResource::class;

    public function getHeading(): string
    {
        return __('messages.add_machine');
    }
}
