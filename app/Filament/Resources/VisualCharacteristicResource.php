<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisualCharacteristicResource\Pages;
use App\Models\VisualCharacteristic;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VisualCharacteristicResource extends Resource
{
  protected static ?string $model = VisualCharacteristic::class;

  protected static ?string $navigationIcon = 'phosphor-eye';

  protected static ?string $navigationGroup = 'Quality Control';

  protected static ?string $navigationParentItem = 'Confirmation Compliances';

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
          ->searchable(),
        Tables\Columns\TextColumn::make('created_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
        Tables\Columns\TextColumn::make('updated_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
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
      'index' => Pages\ListVisualCharacteristics::route('/'),
      'create' => Pages\CreateVisualCharacteristic::route('/create'),
      'edit' => Pages\EditVisualCharacteristic::route('/{record}/edit'),
    ];
  }
}
