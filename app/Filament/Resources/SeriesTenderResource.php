<?php

namespace App\Filament\Resources;

use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\SeriesTenderResource\Pages\ListSeriesTenders;
use App\Filament\Resources\SeriesTenderResource\Pages\ViewSeriesTender;
use App\Filament\Resources\SeriesTenderResource\Pages\EditSeriesTender;
use App\Filament\Resources\SeriesTenderResource\Pages\DieCastingsPage;
use App\Filament\Resources\SeriesTenderResource\Pages\PackagingsPage;
use App\Filament\Resources\SeriesTenderResource\Pages\GrindingPage;
use App\Filament\Resources\SeriesTenderResource\Pages\MachineTrimming;
use App\Filament\Resources\SeriesTenderResource\Pages\TurningWashing;
use App\Filament\Resources\SeriesTenderResource\Pages;
use App\Models\SeriesTender;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\Product;
use Filament\Pages\Page;
use Filament\Navigation\NavigationItem;
use Filament\Tables\Columns\BadgeColumn;
class SeriesTenderResource extends Resource
{
  protected static ?string $model = SeriesTender::class;

  protected static string | \BackedEnum | null $navigationIcon = 'carbon-bare-metal-server';

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
  protected static ?\Filament\Pages\Enums\SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Start;


  public static function form(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make(__('messages.basic_information'))
          ->schema([
            Grid::make(2)
              ->schema([
                TextInput::make('series_number')
                  ->required()
                  ->string()
                  ->maxLength(255)
                  ->label(__('messages.series_number')),

                TextInput::make('company')
                  ->required()
                  ->label(__('messages.company')),

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
              ]),
          ]),

        Section::make(__('messages.series_details'))
          ->schema([
            Grid::make(2)
              ->schema([
                TextInput::make('series_size')
                  ->string()
                  ->maxLength(255)
                  ->label(__('messages.series_size')),

                TextInput::make('series_code')
                  ->string()
                  ->maxLength(255)
                  ->label(__('messages.series_code')),
              ]),
          ]),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        BadgeColumn::make('series_number')
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
      ->recordActions([

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
      'index' => ListSeriesTenders::route('/'),
      'view' => ViewSeriesTender::route('/{record}'),
      'edit' => EditSeriesTender::route('/{record}/edit'),
      'die-castings' => DieCastingsPage::route('/{record}/die-castings'),
      'packaging' => PackagingsPage::route('/{record}/packaging'),
      'grinding' => GrindingPage::route('/{record}/grinding'),
      'machine-trimming' => MachineTrimming::route('/{record}/machine-trimming'),
      'turning-washing' => TurningWashing::route('/{record}/turning-washing'),
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
        ->url(fn() => static::getUrl('view', ['record' => $record]))
        ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.series-tenders.view')),
      NavigationItem::make('edit')
        ->label(__('messages.edit_series_tender'))
        ->icon('heroicon-o-pencil')
        ->url(fn() => static::getUrl('edit', ['record' => $record]))
        ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.series-tenders.edit')),

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

    ];
  }
}
