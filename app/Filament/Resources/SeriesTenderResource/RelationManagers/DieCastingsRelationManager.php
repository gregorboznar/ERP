<?php

namespace App\Filament\Resources\SeriesTenderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\DieCasting;

class DieCastingsRelationManager extends RelationManager
{
  protected static string $relationship = 'dieCastings';

  protected static ?string $recordTitleAttribute = 'id';

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('series_number')
          ->required()
          ->maxLength(255),
      ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('id')
      ->columns([
        Tables\Columns\TextColumn::make('start_datetime')
          ->label(__('messages.start_datetime'))
          ->dateTime('d.m.Y H:i')
          ->sortable(),
        Tables\Columns\TextColumn::make('end_datetime')
          ->label(__('messages.end_datetime'))
          ->dateTime('d.m.Y H:i')
          ->sortable(),
        Tables\Columns\TextColumn::make('counter_start')
          ->label(__('messages.counter_start'))
          ->sortable(),
        Tables\Columns\TextColumn::make('counter_end')
          ->label(__('messages.counter_end'))
          ->sortable(),
        Tables\Columns\TextColumn::make('good_parts_count')
          ->label(__('messages.good_parts_count'))
          ->sortable(),
        Tables\Columns\TextColumn::make('technological_waste')
          ->label(__('messages.technological_waste'))
          ->sortable(),
      ])
      ->filters([
        //
      ])
      ->headerActions([
        Tables\Actions\CreateAction::make(),
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
}
