<?php

namespace App\Filament\Resources\ConfirmationComplianceResource\Pages;

use App\Filament\Resources\ConfirmationComplianceResource;
use Filament\Resources\Pages\Page;
use Filament\Pages\SubNavigationPosition;

class MeasurementCharacteristics extends Page
{
  protected static string $resource = ConfirmationComplianceResource::class;

  protected static string $view = 'filament.resources.confirmation-compliance-resource.pages.measurement-characteristics';

  protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

  public ?string $record = null;

  public function mount(int|string $record): void
  {
    $this->record = $record;
  }
}
