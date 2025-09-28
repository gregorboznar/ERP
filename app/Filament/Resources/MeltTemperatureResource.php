<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MeltTemperatureResource\Pages;
use App\Models\MeltTemperature;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use App\Models\Machine;
use App\Models\SeriesTender;
use App\Models\Product;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TimePicker;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use LaraZeus\InlineChart\Tables\Columns\InlineChart;
use App\Filament\Resources\MeltTemperatureResource\Widgets\TemperatureReadingsChart;


class MeltTemperatureResource extends Resource
{
  protected static ?string $model = MeltTemperature::class;

  protected static ?string $navigationIcon = 'phosphor-thermometer';

  protected static ?string $navigationGroup = 'Quality Control';

  public static function getNavigationLabel(): string
  {
    return __('messages.melt_temperature_plural');
  }

  public static function getPluralModelLabel(): string
  {
    return __('messages.melt_temperature_plural');
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Grid::make(3)
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

        TableRepeater::make('temperature_readings')
          ->relationship('temperatureReadings')
          ->headers([
            Header::make('temperature')->label(__('messages.temperature'))->width('150px'),
            Header::make('recorded_at')->label(__('messages.recorded_at'))->width('150px'),
          ])
          ->schema([
            TextInput::make('temperature')
              ->required()
              ->label(__('messages.temperature'))
              ->numeric()
              ->integer()
              ->extraAttributes(['class' => 'm-3']),
            TimePicker::make('recorded_at')
              ->required()
              ->default(now())
              ->format('H:i')
              ->withoutSeconds()
              ->label(__('messages.recorded_at'))
              ->extraAttributes(['class' => 'm-3']),
          ])
          ->defaultItems(1)
          ->createItemButtonLabel(__('messages.add'))
          ->columnSpanFull()
          ->emptyLabel(__('messages.table_empty'))
          ->streamlined()
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
        InlineChart::make('temperature_readings')
          ->label(__('messages.melt_temperature_chart'))
          ->chart(TemperatureReadingsChart::class)
          ->maxWidth(300)
          ->maxHeight(150),
      ])

      ->actions([
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
      'index' => Pages\ListMeltTemperatures::route('/'),

      'edit' => Pages\EditMeltTemperature::route('/{record}/edit'),
    ];
  }
}
