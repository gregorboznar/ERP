<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisualCharacteristicResource\Pages;
use App\Models\VisualCharacteristic;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class VisualCharacteristicResource extends Resource
{
  protected static ?string $model = VisualCharacteristic::class;

  protected static ?string $navigationIcon = 'phosphor-eye';

  protected static ?string $navigationGroup = 'Quality Control';

  public static function getNavigationLabel(): string
  {
    return __('messages.visual_characteristic_plural');
  }

  public static function getPluralModelLabel(): string
  {
    return __('messages.visual_characteristic_plural');
  }

  public static function getNavigationParentItem(): ?string
  {
    return __('messages.confirmation_compliance');
  }

  protected static ?int $navigationSort = 1;

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
      ->filters([])
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
      'index' => Pages\ListVisualCharacteristics::route('/'),
      'create' => Pages\CreateVisualCharacteristic::route('/create'),
      'edit' => Pages\EditVisualCharacteristic::route('/{record}/edit'),
    ];
  }
}
