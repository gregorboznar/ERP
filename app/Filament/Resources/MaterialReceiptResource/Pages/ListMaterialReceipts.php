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
            Actions\CreateAction::make()->label(__('messages.create_new_material_receipt'))
                ->modalWidth('3xl')
                ->modalHeading(__('messages.create_new_material_receipt'))
                ->modalDescription(__('messages.enter_details_for_new_material_receipt'))
                ->closeModalByClickingAway(true)
                ->createAnother(false)
                ->modalSubmitActionLabel(__('messages.save'))
                ->modalCancelActionLabel(__('messages.cancel')),
        ];
    }
}
