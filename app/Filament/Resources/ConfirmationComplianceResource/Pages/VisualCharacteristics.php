<?php

namespace App\Filament\Resources\ConfirmationComplianceResource\Pages;

use Filament\Pages\Enums\SubNavigationPosition;
use App\Filament\Resources\ConfirmationComplianceResource;
use Filament\Resources\Pages\Page;

class VisualCharacteristics extends Page
{
  protected static string $resource = ConfirmationComplianceResource::class;

  protected string $view = 'filament.resources.confirmation-compliance-resource.pages.visual-characteristics';

  protected static ?\Filament\Pages\Enums\SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

  public ?string $record = null;

  public function mount(int|string $record): void
  {
    $this->record = $record;
  }
}
