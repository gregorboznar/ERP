<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\MeltTemperatureResource\Pages\ListMeltTemperatures;
use App\Filament\Resources\MeltTemperatureResource\Pages\EditMeltTemperature;
use App\Filament\Resources\MeltTemperatureResource\Pages;
use App\Models\MeltTemperature;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use App\Models\Machine;
use App\Models\SeriesTender;
use App\Models\Product;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;


class MeltTemperatureResource extends Resource
{
  protected static ?string $model = MeltTemperature::class;

  protected static string | \BackedEnum | null $navigationIcon = 'phosphor-thermometer';

  protected static string | \UnitEnum | null $navigationGroup = 'Quality Control';

  public static function getNavigationLabel(): string
  {
    return __('messages.melt_temperature_plural');
  }

  public static function getPluralModelLabel(): string
  {
    return __('messages.melt_temperature_plural');
  }

  public static function form(Schema $schema): Schema
  {
    return $schema
      ->components([
        Grid::make(3)
          ->columnSpanFull()
          ->schema([
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

            Select::make('machine_id')
              ->required()
              ->label(__('messages.machine'))
              ->options(Machine::all()->pluck('name', 'id'))
              ->searchable()
              ->default(fn() => Machine::first()?->id),
          ]),

        Repeater::make('temperatureReadings')
          ->relationship()
          ->label(__('messages.melt_temperature_plural'))
          ->table([
            TableColumn::make(__('messages.temperature'))
              ->markAsRequired(),
            TableColumn::make(__('messages.recorded_at'))
              ->markAsRequired(),
          ])
          ->schema([
            TextInput::make('temperature')
              ->required()
              ->label(__('messages.temperature'))
              ->numeric()
              ->integer(),
            TimePicker::make('recorded_at')
              ->required()
              ->default(now())
              ->format('H:i')
              ->withoutSeconds()
              ->label(__('messages.recorded_at')),
          ])
          ->columnSpanFull()
          ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
            return [
              ...$data,
              'recorded_at' => now()->setTimeFromTimeString($data['recorded_at']),
            ];
          }),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('user.name')
          ->label(__('messages.operator'))
          ->searchable(),
        TextColumn::make('series.series_number')
          ->label(__('messages.series_number'))
          ->searchable(),
        TextColumn::make('product.name')
          ->label(__('messages.product_name'))
          ->searchable(),
        TextColumn::make('machine.name')
          ->label(__('messages.machine'))
          ->searchable(),
        TextColumn::make('created_at')
          ->label(__('messages.created_at'))
          ->dateTime('d.m.Y H:i')
          ->sortable(),
        ViewColumn::make('temperature_chart')
          ->label(__('messages.melt_temperature_chart'))
          ->view('filament.tables.columns.temperature-chart')
          ->width('300px'),
      ])

      ->recordActions([
        EditAction::make()
          ->label(__('messages.edit')),
        DeleteAction::make()
          ->label(__('messages.delete'))
          ->modalHeading(__('messages.delete_melt_temperature'))
          ->modalDescription(__('messages.delete_melt_temperature_confirmation'))
          ->modalSubmitActionLabel(__('messages.confirm_delete'))
          ->modalCancelActionLabel(__('messages.cancel'))
          ->successNotificationTitle(__('messages.deleted')),
      ]);
  }

  public static function getPages(): array
  {
    return [
      'index' => ListMeltTemperatures::route('/'),
     /*  'edit' => EditMeltTemperature::route('/{record}/edit'), */
    ];
  }
}
