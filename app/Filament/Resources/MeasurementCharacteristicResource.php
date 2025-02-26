<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MeasurementCharacteristicResource\Pages;
use App\Models\MeasurementCharacteristic;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MeasurementCharacteristicResource extends Resource
{
  protected static ?string $model = MeasurementCharacteristic::class;

  protected static ?string $navigationIcon = 'phosphor-ruler';

  protected static ?string $navigationGroup = 'Quality Control';

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

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('name')
          ->required()
          ->maxLength(255),

      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('name')
          ->label(__('messages.name'))
          ->searchable(),

      ])
      ->filters([
        //
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
      'index' => Pages\ListMeasurementCharacteristics::route('/'),
      'create' => Pages\CreateMeasurementCharacteristic::route('/create'),
      'edit' => Pages\EditMeasurementCharacteristic::route('/{record}/edit'),
    ];
  }
}
