<?php

namespace App\Filament\Resources\DieCastingResource\Pages;

use App\Filament\Resources\DieCastingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDieCastings extends ListRecords
{
    protected static string $resource = DieCastingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('messages.add_new_series'))
                ->modalHeading(__('messages.new_series_tender'))
                ->modalDescription(__('messages.enter_details_for_new_series_tender'))
                ->modalWidth('5xl')
                ->closeModalByClickingAway(true)
                ->createAnother(false),
        ];
    }
}
