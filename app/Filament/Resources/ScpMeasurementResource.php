<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScpMeasurementResource\Pages;
use App\Filament\Resources\ScpMeasurementResource\RelationManagers;
use App\Models\ScpMeasurement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScpMeasurementResource extends Resource
{
    protected static ?string $model = ScpMeasurement::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListScpMeasurements::route('/'),
            'create' => Pages\CreateScpMeasurement::route('/create'),
            'edit' => Pages\EditScpMeasurement::route('/{record}/edit'),
        ];
    }
}
