<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScpMeasurementResource\Pages;
use App\Models\ScpMeasurement;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use App\Models\SeriesTender;
use Filament\Forms\Components\Select;
use App\Models\Product;
use Filament\Forms\Components\Grid;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Tables\Columns\TextColumn;

use Filament\Tables\Actions\ExportAction;
use App\Filament\Exports\ScpMeasurementExporter;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

class ScpMeasurementResource extends Resource
{
    protected static ?string $model = ScpMeasurement::class;

    protected static ?string $navigationIcon = 'carbon-intent-request-active';


    public static function getPluralModelLabel(): string
    {
        return __('messages.scp_measurements');
    }


    public static function getNavigationLabel(): string
    {
        return trans('messages.scp_measurements');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        DateTimePicker::make('datetime')
                            ->required()
                            ->native(false)
                            ->label(__('messages.datetime'))
                            ->default(now()),

                        TextInput::make('date')
                            ->hidden(),
                        TextInput::make('time')
                            ->hidden(),

                        Select::make('series_id')
                            ->required()
                            ->label(__('messages.series_number'))
                            ->options(SeriesTender::all()->pluck('series_number', 'id'))
                            ->searchable()
                            ->default(fn() => SeriesTender::latest()->first()?->id),

                        Select::make('product_id')
                            ->required()
                            ->label(__('messages.product_name'))
                            ->options(Product::all()->pluck('name', 'id'))
                            ->searchable()
                            ->default(function (callable $get) {
                                $seriesId = $get('series_id');
                                if (!$seriesId) return null;
                                $seriesTender = SeriesTender::find($seriesId);
                                return $seriesTender ? $seriesTender->product_id : null;
                            }),

                    ]),
                TableRepeater::make('scp_measurement_fields')
                    ->relationship('measurementFields')
                    ->headers([
                        Header::make('field_number')->label(__('messages.part'))->width('100px'),
                        Header::make('nest_number')->label(__('messages.nest'))->width('150px'),
                        Header::make('measurement_value')->label(__('messages.measurement_value'))->width('150px'),
                    ])
                    ->schema([
                        TextInput::make('field_number')
                            ->label(__('messages.nest'))
                            ->readOnly()
                            ->required()
                            ->default(function (callable $get, ?string $state) {
                                if ($state) return $state;
                                $items = $get('../../scp_measurement_fields') ?? [];
                                $existingNumbers = collect($items)->pluck('field_number')->filter()->toArray();
                                return empty($existingNumbers) ? 1 : max($existingNumbers) + 1;
                            })
                            ->afterStateHydrated(function (TextInput $component, $state) {
                                if (!$state) {
                                    $component->state(1);
                                }
                            }),
                        TextInput::make('nest_number')
                            ->required()
                            ->label(__('messages.nest_number'))
                            ->numeric()
                            ->integer()
                            ->extraAttributes(['class' => 'm-3']),
                        TextInput::make('measurement_value')
                            ->required()
                            ->label(__('messages.measurement_value'))
                            ->numeric()
                            ->step('0.001')
                            ->extraAttributes(['class' => 'm-3']),
                    ])
                    ->defaultItems(5)
                    ->createItemButtonLabel(__('messages.add'))
                    ->columnSpanFull()
                    ->emptyLabel(__('messages.table_empty'))
                    ->streamlined()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([

                TextColumn::make('scpMeasurementFields.nest_number')
                    ->label(__('messages.nest'))
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function ($record) {
                        return $record->measurementFields->first()?->nest_number;
                    }),

                TextColumn::make('measurement_values')
                    ->label(__('messages.measurement_value'))
                    ->getStateUsing(function ($record) {
                        $values = $record->measurementFields->map(fn($field) => (float)$field->measurement_value)->sort();

                        if ($values->isEmpty()) {
                            return '';
                        }
                        $lowest = $values->first();
                        $highest = $values->last();
                        return "{$lowest} - {$highest}";
                    })
                    ->tooltip(function ($record) {
                        $values = $record->measurementFields->map(fn($field) => $field->measurement_value);
                        return $values->implode(', ');
                    })
                    ->sortable()
                    ->searchable()
                    ->html()
                    ->wrap(),
                TextColumn::make('series.series_number')
                    ->label(__('messages.series_number'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('product.name')
                    ->label(__('messages.product_name'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label(__('messages.operator'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('datetime')
                    ->label(__('messages.datetime'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->searchable(),



            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()
                    ->label(__('messages.edit')),
                DeleteAction::make()
                    ->label(__('messages.delete'))
                    ->modalHeading(__('messages.delete_scp_measurement'))
                    ->modalDescription(__('messages.delete_scp_confirmation'))
                    ->modalSubmitActionLabel(__('messages.confirm_delete'))
                    ->modalCancelActionLabel(__('messages.cancel'))
                    ->successNotificationTitle(__('messages.deleted')),
            ])

            ->headerActions([
                /*  ExportAction::make()
                    ->exporter(ScpMeasurementExporter::class)
                    ->label(__('messages.export'))
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Export started')
                            ->body('Your export has begun and will be processed in the background. You will receive a notification with the download link when it is complete.')
                    ), */

                /*   Action::make('downloadLatestExport')
                    ->label(__('messages.download_excel_template'))
                    ->url(route('scp-measurements.fresh-export-download'))
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('primary')
                    ->openUrlInNewTab(true) */]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListScpMeasurements::route('/'),
            'edit' => Pages\EditScpMeasurement::route('/{record}/edit'),
        ];
    }
}
