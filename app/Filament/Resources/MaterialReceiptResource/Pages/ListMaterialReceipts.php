<?php

namespace App\Filament\Resources\MaterialReceiptResource\Pages;

use App\Filament\Resources\MaterialReceiptResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListMaterialReceipts extends ListRecords
{
    protected static string $resource = MaterialReceiptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalWidth('3xl')
                ->modalHeading('Create New Material Receipt')
                ->modalDescription('Enter the details for the new material receipt')
                ->closeModalByClickingAway(true)
                ->createAnother(false),
        ];
    }
}
