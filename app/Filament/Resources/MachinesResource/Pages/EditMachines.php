<?php

namespace App\Filament\Resources\MachinesResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\MachinesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMachines extends EditRecord
{
    protected static string $resource = MachinesResource::class;

    public function getHeading(): string
    {
        return __('messages.edit_machine') . ' - ' . $this->record->name;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
