<?php

namespace App\Filament\Resources\SeriesTenderResource\Pages;

use App\Filament\Resources\SeriesTenderResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use App\Models\DieCasting;
use Filament\Actions\CreateAction;
use App\Models\SeriesTender;

class DieCastingsPage extends ListRecords
{
  protected static string $resource = SeriesTenderResource::class;

  public function getTitle(): string
  {
    return __('messages.die_castings');
  }

  protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
  {
    $seriesTenderId = request()->route('record');
    return DieCasting::query()->where('series_tender_id', $seriesTenderId);
  }

  protected function configureTable(Table $table): Table
  {
    return $table
      ->defaultSort('date', 'desc')
      ->columns([
        TextColumn::make('date')
          ->label(__('messages.date'))
          ->date('d.m.Y')
          ->sortable(),
        TextColumn::make('start_time')
          ->label(__('messages.start_time'))
          ->time('H:i')
          ->sortable(),
        TextColumn::make('end_time')
          ->label(__('messages.end_time'))
          ->time('H:i')
          ->sortable(),
        TextColumn::make('counter_start')
          ->label(__('messages.counter_start'))
          ->sortable(),
        TextColumn::make('counter_end')
          ->label(__('messages.counter_end'))
          ->sortable(),
        TextColumn::make('good_parts_count')
          ->label(__('messages.good_parts_count'))
          ->sortable(),
        TextColumn::make('technological_waste')
          ->label(__('messages.technological_waste'))
          ->sortable(),
        TextColumn::make('batch_of_material')
          ->label(__('messages.batch_of_material'))
          ->sortable(),
        TextColumn::make('palet_number')
          ->label(__('messages.palet_number'))
          ->sortable(),
      ])
      ->actions([
        EditAction::make(),
        DeleteAction::make(),
      ])
      ->bulkActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ]);
  }

  protected function getHeaderActions(): array
  {
    return [
      CreateAction::make()
        ->label(__('messages.new_die_casting'))
        ->modalHeading(__('messages.new_die_casting'))
        ->modalDescription(__('messages.enter_details_for_new_die_casting'))
        ->modalWidth('5xl')
        ->closeModalByClickingAway(true)
        ->createAnother(false)
        ->using(function (array $data) {
          $seriesTenderId = request()->route('record');
          $data['series_tender_id'] = $seriesTenderId;
          return DieCasting::create($data);
        }),
    ];
  }
}
