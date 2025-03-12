<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MeltTemperatureResource\Pages;
use App\Models\MeltTemperature;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use App\Models\Machine;
use App\Models\SeriesTender;
use App\Models\Product;
use Filament\Forms\Components\Hidden;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Repeater;

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
              ->default(SeriesTender::latest()->first()->id),

            Select::make('product_id')
              ->required()
              ->label(__('messages.product_name'))
              ->options(Product::all()->pluck('name', 'id'))
              ->searchable()
              ->default(function (callable $get) {
                $seriesTender = SeriesTender::find($get('series_id'));
                return $seriesTender ? $seriesTender->product_id : null;
              }),

            Select::make('machine_id')
              ->required()
              ->label(__('messages.machine'))
              ->options(Machine::all()->pluck('name', 'id'))
              ->searchable()
              ->default(Machine::first()->id),
          ]),

        // Replace the fixed temperature and time fields with a repeater
        Repeater::make('temperature_readings')
          ->label(__('messages.temperature_readings'))
          ->schema([
            Grid::make(2)
              ->schema([
                TextInput::make('temperature')
                  ->required()
                  ->label(__('messages.temperature'))
                  ->numeric()
                  ->integer(),

                TimePicker::make('recorded_at')
                  ->required()
                  ->default(now()->format('H:i'))
                  ->format('H:i')
                  ->withoutSeconds()
                  ->label(__('messages.recorded_at')),
              ]),
          ])
          ->grid(1)
          ->defaultItems(1)
          ->createItemButtonLabel(__('messages.add_temperature'))
          ->collapsible()
          ->columnSpanFull()
          ->itemLabel(function (array $state): ?string {
            if (isset($state['temperature']) && isset($state['recorded_at'])) {
              return __('messages.temperature') . ': ' . $state['temperature'] . ' - ' . $state['recorded_at'];
            }

            return null;
          }),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('user.name')
          ->label(__('messages.operator'))
          ->searchable(),
        Tables\Columns\TextColumn::make('series.series_number')
          ->label(__('messages.series_number'))
          ->searchable(),
        Tables\Columns\TextColumn::make('product.name')
          ->label(__('messages.product_name'))
          ->searchable(),
        Tables\Columns\TextColumn::make('machine.name')
          ->label(__('messages.machine'))
          ->searchable(),
        Tables\Columns\TextColumn::make('created_at')
          ->label(__('messages.created_at'))
          ->dateTime('d.m.Y H:i')
          ->sortable(),
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
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
