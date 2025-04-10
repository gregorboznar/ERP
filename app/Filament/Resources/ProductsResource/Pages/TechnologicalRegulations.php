<?php

namespace App\Filament\Resources\ProductsResource\Pages;

use App\Filament\Resources\ProductsResource;
use Filament\Resources\Pages\Page;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Navigation\NavigationItem;
use Filament\Pages\SubNavigationPosition;

class TechnologicalRegulations extends Page
{
  protected static string $resource = ProductsResource::class;

  protected static ?string $navigationIcon = 'heroicon-o-document-text';

  protected static string $view = 'filament.pages.custom-page';

  protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

  public ?string $record = null;

  public function mount(int|string $record): void
  {
    $this->record = $record;
  }


  public function getSubNavigation(): array
  {
    return ProductsResource::generateNavigation($this->record);
  }
  public function infolist(Infolist $infolist): Infolist
  {
    return $infolist
      ->record(ProductsResource::getModel()::find($this->record))
      ->schema([
        Section::make('Technological Regulations')
          ->schema([
            TextEntry::make('name')
              ->label('Product Name'),
            // Add more technological regulations fields here
          ])
      ]);
  }
}
