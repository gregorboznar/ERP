<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeriesTenderResource\Pages;
use App\Models\SeriesTender;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use App\Models\Product;
use Filament\Forms\Components\Grid;

class SeriesTenderResource extends Resource
{
  protected static ?string $model = SeriesTender::class;

  protected static ?string $navigationIcon = 'carbon-bare-metal-server';

  public static function getNavigationLabel(): string
  {
    return __('messages.series_tender');
  }
  public static function getNavigationGroup(): ?string
  {
    return 'Operativa';
  }
  public static function getPluralModelLabel(): string
  {
    return __('messages.series_tender');
  }


  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Grid::make(3)
          ->schema([
            TextInput::make('series_number')
              ->required()
              ->string()
              ->maxLength(255)
              ->label(__('messages.series_number')),

            TextInput::make('company')
              ->required()->label(__('messages.company')),

            Select::make('product_id')
              ->required()
              ->label(__('messages.product'))
              ->options(Product::all()->pluck('name', 'id'))
              ->searchable(),

            DatePicker::make('tender_date')
              ->required()->native(false)
              ->label(__('messages.tender_date')),
          ])
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
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
      ->actions([
        EditAction::make(),
        DeleteAction::make()
          ->modalHeading(__('messages.delete_series_tender'))
          ->modalDescription(__('messages.delete_series_tender_confirmation'))
          ->successNotificationTitle(__('messages.deleted')),
      ])
      ->defaultSort('series_number');
  }

  public static function getRelations(): array
  {
    return [];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListSeriesTenders::route('/'),
      'edit' => Pages\EditSeriesTender::route('/{record}/edit'),
    ];
  }

  public static function getNavigationBadge(): ?string
  {
    return static::getModel()::count();
  }
}
