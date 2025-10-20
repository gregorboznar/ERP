<?php

namespace App\Filament\Resources\ProductsResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\ProductsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductsResource::class;

    protected function getHeaderActions(): array
    {
        return [

            CreateAction::make()->label(__('messages.new_product'))
                ->modalHeading(__('messages.new_product'))
                ->modalDescription(__('messages.enter_details_for_new_product'))
                ->modalWidth('xl')
                ->closeModalByClickingAway(true)
                ->createAnother(false)
                ->modalSubmitActionLabel(__('messages.save'))
                ->modalCancelActionLabel(__('messages.cancel')),
        ];
    }
}
