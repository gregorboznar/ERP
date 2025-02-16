<?php

namespace App\Filament\Resources\ProductsResource\Pages;

use App\Filament\Resources\ProductsResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Pages\SubNavigationPosition;
use Filament\Navigation\NavigationItem;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;

class ViewProducts extends ViewRecord
{
  protected static string $resource = ProductsResource::class;

  protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

  public function getSubNavigation(): array
  {
    return [
      NavigationItem::make('view')
        ->label('Details')
        ->icon('heroicon-o-eye')
        ->url(fn() => ProductsResource::getUrl('view', ['record' => $this->record]))
        ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.products.view', ['record' => $this->record])),

      NavigationItem::make('technological-regulations')
        ->label('Technological Regulations')
        ->icon('heroicon-o-document-text')
        ->url(fn() => ProductsResource::getUrl('technological-regulations', ['record' => $this->record])),

      NavigationItem::make('confirmation-compliance')
        ->label('Confirmation Compliance')
        ->icon('heroicon-o-check-circle')
        ->url(fn() => ProductsResource::getUrl('confirmation-compliance', ['record' => $this->record])),
    ];
  }

  public function confirmationComplianceInfolist(Infolist $infolist): Infolist
  {
    return $infolist
      ->schema([
        Section::make('Confirmation Compliance Details')
          ->schema([
            TextEntry::make('name')
              ->label('Product Name'),
            // Add more confirmation-compliance related fields here
          ])
      ]);
  }
}
