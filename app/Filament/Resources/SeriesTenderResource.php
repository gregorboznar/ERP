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
use Filament\Tables\Actions\ViewAction;
use App\Models\Product;
use Filament\Forms\Components\Grid;
use Filament\Pages\SubNavigationPosition;
use Filament\Pages\Page;

use Filament\Navigation\NavigationItem;

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
  protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Start;


  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Grid::make(2)
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
              ->required()
              ->native(false)
              ->default(now())
              ->label(__('messages.tender_date')),
            TextInput::make('series_size')
              ->string()
              ->maxLength(255)
              ->label(__('messages.series_size')),
            TextInput::make('series_code')

              ->string()
              ->maxLength(255)
              ->label(__('messages.series_code')),
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
        TextColumn::make('series_size')
          ->label(__('messages.series_size'))
          ->sortable()
          ->searchable(),

        TextColumn::make('tender_date')
          ->label(__('messages.tender_date'))
          ->date('d.m.Y')
          ->sortable(),
      ])
      ->actions([

        EditAction::make()
          ->label(__('messages.edit')),
        DeleteAction::make()
          ->label(__('messages.delete'))
          ->modalHeading(__('messages.delete_series_tender'))
          ->modalDescription(__('messages.delete_series_tender_confirmation'))
          ->modalSubmitActionLabel(__('messages.confirm_delete'))
          ->modalCancelActionLabel(__('messages.cancel'))
          ->successNotificationTitle(__('messages.deleted')),
      ])
      ->defaultSort('series_number')
      ->modifyQueryUsing(fn($query) => $query->getModel() instanceof SeriesTender ? $query : $query->reorder());
  }



  public static function getPages(): array
  {
    return [
      'index' => Pages\ListSeriesTenders::route('/'),
      'view' => Pages\ViewSeriesTender::route('/{record}'),
      'edit' => Pages\EditSeriesTender::route('/{record}/edit'),
      'die-castings' => Pages\DieCastingsPage::route('/{record}/die-castings'),
      'packaging' => Pages\PackagingsPage::route('/{record}/packaging'),
      'grinding' => Pages\GrindingPage::route('/{record}/grinding'),
      'machine-trimming' => Pages\MachineTrimming::route('/{record}/machine-trimming'),
      'turning-washing' => Pages\TurningWashing::route('/{record}/turning-washing'),
    ];
  }

  public static function getRecordSubNavigation(Page $page): array
  {
    return static::generateNavigation($page->getRecord());
  }

  public static function getNavigationBadge(): ?string
  {
    return static::getModel()::count();
  }


  public static function generateNavigation($record): array
  {
    return [
      NavigationItem::make('view')
        ->label(__('messages.view_series_tender'))
        ->icon('heroicon-o-eye')
        ->url(fn() => static::getUrl('view', ['record' => $record])),

      NavigationItem::make('die-castings')
        ->label(__('messages.die_castings'))
        ->icon('heroicon-o-rectangle-stack')
        ->url(fn() => static::getUrl('die-castings', ['record' => $record]))
        ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.series-tenders.die-castings')),

      NavigationItem::make('grinding')
        ->label(__('messages.grinding'))
        ->icon('heroicon-o-adjustments-vertical')
        ->url(fn() => static::getUrl('grinding', ['record' => $record]))
        ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.series-tenders.grinding')),

      NavigationItem::make('machine-trimming')
        ->label(__('messages.machine_trimming'))
        ->icon('heroicon-o-cog')
        ->url(fn() => static::getUrl('machine-trimming', ['record' => $record]))
        ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.series-tenders.machine-trimming')),

      NavigationItem::make('turning-washing')
        ->label(__('messages.turning_washing'))
        ->icon('heroicon-o-arrow-path')
        ->url(fn() => static::getUrl('turning-washing', ['record' => $record]))
        ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.series-tenders.turning-washing')),

      NavigationItem::make('packaging')
        ->label(__('messages.packaging'))
        ->icon('heroicon-o-archive-box')
        ->url(fn() => static::getUrl('packaging', ['record' => $record]))
        ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.series-tenders.packaging')),

      NavigationItem::make('edit')
        ->label(__('messages.edit_series_tender'))
        ->icon('heroicon-o-pencil')
        ->url(fn() => static::getUrl('edit', ['record' => $record])),
    ];
  }
}
