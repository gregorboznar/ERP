<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MeltTemperatureResource\Pages;
use App\Models\MeltTemperature; // Ensure you have this model created
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

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
        Forms\Components\TextInput::make('temperature')
          ->required()
          ->numeric()
          ->label(__('messages.temperature'))
          ->maxLength(255),
        Forms\Components\DateTimePicker::make('recorded_at')
          ->required()
          ->label(__('messages.recorded_at')),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('temperature')
          ->label(__('messages.temperature'))
          ->searchable(),
        Tables\Columns\TextColumn::make('recorded_at')
          ->label(__('messages.recorded_at'))
          ->dateTime(),
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
      'create' => Pages\CreateMeltTemperature::route('/create'),
      'edit' => Pages\EditMeltTemperature::route('/{record}/edit'),
    ];
  }
}
