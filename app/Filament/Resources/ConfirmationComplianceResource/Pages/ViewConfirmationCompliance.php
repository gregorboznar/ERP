<?php

namespace App\Filament\Resources\ConfirmationComplianceResource\Pages;

use Filament\Pages\Enums\SubNavigationPosition;
use App\Filament\Resources\ConfirmationComplianceResource;
use Filament\Resources\Pages\ViewRecord;

class ViewConfirmationCompliance extends ViewRecord
{
  protected static string $resource = ConfirmationComplianceResource::class;

  protected static ?\Filament\Pages\Enums\SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
}
