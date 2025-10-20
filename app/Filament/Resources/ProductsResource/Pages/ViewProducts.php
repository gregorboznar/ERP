<?php

namespace App\Filament\Resources\ProductsResource\Pages;

use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use App\Filament\Resources\ProductsResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Navigation\NavigationItem;
use Filament\Infolists\Components\TextEntry;

class ViewProducts extends ViewRecord
{
  protected static string $resource = ProductsResource::class;

  protected static ?\Filament\Pages\Enums\SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

  public function getTitle(): string
  {
    return $this->record->name;
  }

  public function getSubNavigation(): array
  {
    return ProductsResource::generateNavigation($this->record);
  }

  public function infolist(Schema $schema): Schema
  {
    return $schema
      ->schema([
        Section::make('Details')
          ->schema([
            TextEntry::make('name')
              ->label(__('messages.name')),
            TextEntry::make('code')
              ->label(__('messages.code')),
            TextEntry::make('nest_number')
              ->label(__('messages.nest_number')),
          ])
      ]);
  }
}
