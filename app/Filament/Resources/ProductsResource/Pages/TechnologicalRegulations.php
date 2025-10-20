<?php

namespace App\Filament\Resources\ProductsResource\Pages;

use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use App\Filament\Resources\ProductsResource;
use Filament\Resources\Pages\Page;
use Filament\Infolists\Components\TextEntry;
use Filament\Navigation\NavigationItem;

class TechnologicalRegulations extends Page
{
  protected static string $resource = ProductsResource::class;

  protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

  protected string $view = 'filament.pages.custom-page';

  protected static ?\Filament\Pages\Enums\SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

  public ?string $record = null;

  public function mount(int|string $record): void
  {
    $this->record = $record;
  }


  public function getSubNavigation(): array
  {
    return ProductsResource::generateNavigation($this->record);
  }
  public function infolist(Schema $schema): Schema
  {
    return $schema
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
