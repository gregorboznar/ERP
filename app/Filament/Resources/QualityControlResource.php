<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QualityControlResource\Pages\ListQualityControls;
use App\Filament\Resources\QualityControlResource\Pages;
use App\Models\MeasurementCharacteristic;
use App\Models\MaintenancePoint;
use Filament\Resources\Resource;

class QualityControlResource extends Resource
{
    protected static ?string $model = MeasurementCharacteristic::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-clipboard-document-check';
    
    protected static string | \UnitEnum | null $navigationGroup = 'Quality Control';
    
    protected static ?int $navigationSort = -1;

    public static function getNavigationLabel(): string
    {
        return __('messages.quality_control');
    }

    public static function getPluralModelLabel(): string
    {
        return __('messages.quality_control');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQualityControls::route('/'),
        ];
    }
}
