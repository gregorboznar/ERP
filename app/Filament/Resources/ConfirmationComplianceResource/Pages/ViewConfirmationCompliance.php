<?php

namespace App\Filament\Resources\ConfirmationComplianceResource\Pages;

use App\Filament\Resources\ConfirmationComplianceResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Pages\SubNavigationPosition;

class ViewConfirmationCompliance extends ViewRecord
{
  protected static string $resource = ConfirmationComplianceResource::class;

  protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
}
