<?php

namespace App\Filament\Resources\ConfirmationComplianceResource\Pages;

use App\Filament\Resources\ConfirmationComplianceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConfirmationCompliances extends ListRecords
{
    protected static string $resource = ConfirmationComplianceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
