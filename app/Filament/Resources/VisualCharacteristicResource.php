<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\VisualCharacteristicResource\Pages\ListVisualCharacteristics;
use App\Filament\Resources\VisualCharacteristicResource\Pages\CreateVisualCharacteristic;
use App\Filament\Resources\VisualCharacteristicResource\Pages\EditVisualCharacteristic;
use App\Filament\Resources\VisualCharacteristicResource\Pages;
use App\Models\VisualCharacteristic;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class VisualCharacteristicResource extends Resource
{
  protected static ?string $model = VisualCharacteristic::class;

  protected static string | \BackedEnum | null $navigationIcon = 'phosphor-eye';

  protected static string | \UnitEnum | null $navigationGroup = 'Quality Control';

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
      ->filters([])
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
      'index' => ListVisualCharacteristics::route('/'),
      'create' => CreateVisualCharacteristic::route('/create'),
      'edit' => EditVisualCharacteristic::route('/{record}/edit'),
    ];
  }
}
