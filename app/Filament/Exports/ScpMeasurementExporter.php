<?php

namespace App\Filament\Exports;

use App\Models\ScpMeasurement;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Filament\Notifications\Notification;

class ScpMeasurementExporter extends Exporter
{
    protected static ?string $model = ScpMeasurement::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('datetime')
                ->label(__('messages.datetime'))
                ->formatStateUsing(fn($state) => $state->format('d.m.Y H:i')),
            ExportColumn::make('user.name')
                ->label(__('messages.operator')),
            ExportColumn::make('series.series_number')
                ->label(__('messages.series_number')),
            ExportColumn::make('product.name')
                ->label(__('messages.product_name')),
            ExportColumn::make('measurementFields')
                ->label(__('messages.measurements'))
                ->state(function (ScpMeasurement $record) {
                    return $record->measurementFields->map(function ($field) {
                        return sprintf(
                            'Part %d: Nest %d = %s',
                            $field->field_number,
                            $field->nest_number,
                            $field->measurement_value
                        );
                    })->join("\n");
                }),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your scp measurement export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    public static function getCompletedNotification(Export $export): Notification
    {
        return Notification::make()
            ->success()
            ->title('Export completed')
            ->body(self::getCompletedNotificationBody($export))
            ->actions([
                \Filament\Notifications\Actions\Action::make('download')
                    ->label('Download')
                    ->url(fn() => $export->getDownloadUrl())
                    ->openUrlInNewTab(),
            ]);
    }
}
