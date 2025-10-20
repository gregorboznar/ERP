<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\MeasurementCharacteristicResource\Pages\ListMeasurementCharacteristics;
use App\Filament\Resources\MeasurementCharacteristicResource\Pages\CreateMeasurementCharacteristic;
use App\Filament\Resources\MeasurementCharacteristicResource\Pages\EditMeasurementCharacteristic;
use App\Filament\Resources\MeasurementCharacteristicResource\Pages;
use App\Models\MeasurementCharacteristic;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;

class MeasurementCharacteristicResource extends Resource
{
  protected static ?string $model = MeasurementCharacteristic::class;

  protected static string | \BackedEnum | null $navigationIcon = 'phosphor-ruler';

  protected static string | \UnitEnum | null $navigationGroup = 'Quality Control';

  protected static ?int $navigationSort = 0;
  public static function getNavigationLabel(): string
  {
    return __('messages.measurement_characteristic_plural');
  }

  public static function getPluralModelLabel(): string
  {
    return __('messages.measurement_characteristic_plural');
  }


  public static function getNavigationParentItem(): ?string
  {
    return __('messages.confirmation_compliance');
  }

  public static function getNavigationGroup(): ?string
  {
    return __('Quality Control');
  }

  public static function form(Schema $schema): Schema
  {
    return $schema
      ->components([
        TextInput::make('name')
          ->required()
          ->maxLength(255),

      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('name')
          ->label(__('messages.name'))
          ->searchable(),

      ])
      ->filters([
        //
      ])
      ->recordActions([
        EditAction::make(),
        DeleteAction::make(),
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ]);
  }

  public static function getPages(): array
  {
    return [
      'index' => ListMeasurementCharacteristics::route('/'),
      'create' => CreateMeasurementCharacteristic::route('/create'),
      'edit' => EditMeasurementCharacteristic::route('/{record}/edit'),
    ];
  }
}
