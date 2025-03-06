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


        Grid::make(4)
          ->schema([
            TextInput::make('temperature_1')
              ->required()
              ->label(__('messages.temperature_1'))
              ->numeric()
              ->integer(),

            TextInput::make('temperature_2')
              ->required()
              ->label(__('messages.temperature_2'))
              ->numeric()
              ->integer(),

            TextInput::make('temperature_3')
              ->required()
              ->label(__('messages.temperature_3'))
              ->numeric()
              ->integer(),

            TextInput::make('temperature_4')
              ->required()
              ->label(__('messages.temperature_4'))
              ->numeric()
              ->integer(),
          ]),
        Grid::make(4)
          ->schema([
            TimePicker::make('recorded_at_1')
              ->required()
              ->default(now()->format('H:i'))
              ->format('H:i')
              ->withoutSeconds() // This removes the seconds select
              ->label(__('messages.recorded_at')),

            TimePicker::make('recorded_at_2')
              ->required()
              ->format('H:i')
              ->withoutSeconds()
              ->label(__('messages.recorded_at')),

            TimePicker::make('recorded_at_3')
              ->required()
              ->format('H:i')
              ->withoutSeconds()
              ->label(__('messages.recorded_at')),

            TimePicker::make('recorded_at_4')
              ->required()
              ->format('H:i')
              ->withoutSeconds()
              ->label(__('messages.recorded_at')),
          ])

      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('user.name')
          ->label(__('messages.operator'))
          ->searchable(),
        Tables\Columns\TextColumn::make('temperature_1')
          ->label(__('messages.temp_1'))
          ->searchable(),
        Tables\Columns\TextColumn::make('temperature_2')
          ->label(__('messages.temp_2'))
          ->searchable(),
        Tables\Columns\TextColumn::make('temperature_3')
          ->label(__('messages.temp_3'))
          ->searchable(),
        Tables\Columns\TextColumn::make('temperature_4')
          ->label(__('messages.temp_4'))
          ->searchable(),
        Tables\Columns\TextColumn::make('product.name')
          ->label(__('messages.product_name'))
          ->searchable(),
        Tables\Columns\TextColumn::make('machine.name')
          ->label(__('messages.machine'))
          ->searchable(),

        Tables\Columns\TextColumn::make('recorded_at_1')
          ->label(__('messages.recorded_at'))
          ->dateTime('d.m.Y H:i'),
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
