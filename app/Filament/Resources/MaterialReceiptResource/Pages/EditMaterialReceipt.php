<?php

namespace App\Filament\Resources\MaterialReceiptResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\MaterialReceiptResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMaterialReceipt extends EditRecord
{
    protected static string $resource = MaterialReceiptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
