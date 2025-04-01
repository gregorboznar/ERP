<?php

namespace App\Filament\Resources\ScpMeasurementResource\Pages;

use App\Filament\Resources\ScpMeasurementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\ExportAction;
use App\Filament\Exports\ScpMeasurementExporter;

class ListScpMeasurements extends ListRecords
{
    protected static string $resource = ScpMeasurementResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Actions\CreateAction::make()->label(__('messages.new_scp_measurement'))
                ->modalHeading(__('messages.new_scp_measurement'))
                ->modalDescription(__('messages.enter_details_for_new_scp_measurement'))
                ->modalWidth('3xl')
                ->closeModalByClickingAway(true)
                ->createAnother(false)
                ->modalSubmitActionLabel(__('messages.save'))
                ->modalCancelActionLabel(__('messages.cancel')),
        ];
    }
}
