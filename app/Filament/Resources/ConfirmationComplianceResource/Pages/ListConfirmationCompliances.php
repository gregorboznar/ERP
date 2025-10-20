<?php

namespace App\Filament\Resources\ConfirmationComplianceResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\ConfirmationComplianceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConfirmationCompliances extends ListRecords
{
    protected static string $resource = ConfirmationComplianceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
