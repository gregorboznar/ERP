<?php

namespace App\Filament\Resources;

class ActivityResource extends \Jacobtims\FilamentLogger\Resources\ActivityResource
{
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}


