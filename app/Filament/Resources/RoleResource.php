<?php

namespace App\Filament\Resources;

class RoleResource extends \BezhanSalleh\FilamentShield\Resources\Roles\RoleResource
{
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}

