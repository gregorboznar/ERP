<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Support\Facades\FilamentView;

class MaintenanceChecks extends Page
{
  protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
  protected static ?string $navigationLabel = 'Maintenance Checks';
  protected static ?string $title = 'Maintenance Checks';
  protected static ?string $slug = 'maintenance-checks-dashboard';
  protected static ?int $navigationSort = 3;
  protected static ?string $model = null;
  protected static bool $shouldRegisterNavigation = true;

  protected static string $view = 'filament.pages.maintenance-checks';

  public static function getSlug(): string
  {
      return static::$slug ?? 'maintenance-checks';
  }

  protected function getHeaderActions(): array
  {
      return [];
  }

  protected function getViewData(): array
  {
      return [];
  }
}
