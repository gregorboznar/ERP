<?php

namespace App\Filament\Resources\SeriesTenderResource\Pages;

use App\Filament\Resources\SeriesTenderResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables;

class ViewSeriesTender extends ViewRecord
{
  protected static string $resource = SeriesTenderResource::class;

  public function getTitle(): string
  {
    return __('messages.view_series_tender');
  }

  public function table(Table $table): Table
  {
    return $table
      ->query(SeriesTenderResource::getEloquentQuery()->where('id', $this->record->id))
      ->columns([
        TextColumn::make('series_number')
          ->label(__('messages.series_number'))
          ->formatStateUsing(fn($state) => str_pad($state, strlen($state), '0', STR_PAD_LEFT))
          ->sortable()
          ->searchable(),

        TextColumn::make('company')
          ->label(__('messages.company'))
          ->sortable()
          ->searchable(),

        TextColumn::make('product.name')
          ->label(__('messages.product'))
          ->sortable()
          ->searchable(),

        TextColumn::make('tender_date')
          ->label(__('messages.tender_date'))
          ->date()
          ->sortable(),
      ])
      ->filters([
        //
      ])
      ->actions([
        EditAction::make(),
      ])
      ->bulkActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ]);
  }
}
