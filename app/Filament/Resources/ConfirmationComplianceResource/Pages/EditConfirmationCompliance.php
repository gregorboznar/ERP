<?php

namespace App\Filament\Resources\ConfirmationComplianceResource\Pages;

use App\Filament\Resources\ConfirmationComplianceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditConfirmationCompliance extends EditRecord
{
    protected static string $resource = ConfirmationComplianceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
