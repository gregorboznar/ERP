<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeriesTenderResource\Pages;
use App\Models\SeriesTender;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

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


  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        TextInput::make('series_number')
          ->required()
          ->numeric()
          ->label('Series Number'),
        TextInput::make('series_name')
          ->required()
          ->label('Series Name'),
        TextInput::make('company')
          ->required(),
        TextInput::make('article')
          ->required(),
        DatePicker::make('tender_date')
          ->required()
          ->label('Tender Date'),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('series_number')
          ->label(__('messages.series_number'))
          ->sortable()
          ->searchable(),
        TextColumn::make('series_name')
          ->label(__('messages.series_name'))
          ->sortable()
          ->searchable(),
        TextColumn::make('company')
          ->label(__('messages.company'))
          ->sortable()
          ->searchable(),
        TextColumn::make('article')
          ->label(__('messages.article'))
          ->sortable()
          ->searchable(),
        TextColumn::make('tender_date')
          ->label(__('messages.tender_date'))
          ->date()
          ->sortable(),
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
      'create' => Pages\CreateSeriesTender::route('/create'),
      'edit' => Pages\EditSeriesTender::route('/{record}/edit'),
    ];
  }
}
