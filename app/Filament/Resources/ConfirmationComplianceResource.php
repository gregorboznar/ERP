<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConfirmationComplianceResource\Pages;
use App\Filament\Resources\ConfirmationComplianceResource\RelationManagers;
use App\Models\ConfirmationCompliance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Pages\Page;

class ConfirmationComplianceResource extends Resource
{
    protected static ?string $model = ConfirmationCompliance::class;

    protected static ?string $navigationIcon = 'phosphor-check-circle';

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
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListConfirmationCompliances::route('/'),
            'create' => Pages\CreateConfirmationCompliance::route('/create'),
            'edit' => Pages\EditConfirmationCompliance::route('/{record}/edit'),
            'view' => Pages\ViewConfirmationCompliance::route('/{record}'),
            'visual-characteristics' => Pages\VisualCharacteristics::route('/{record}/visual-characteristics'),
            'measurement-characteristics' => Pages\MeasurementCharacteristics::route('/{record}/measurement-characteristics'),
        ];
    }

    public static function getRecordSubNavigation(\Filament\Pages\Page $page): array
    {
        return [
            'view' => Pages\ViewConfirmationCompliance::class,
            'visual-characteristics' => Pages\VisualCharacteristics::class,
            'measurement-characteristics' => Pages\MeasurementCharacteristics::class,
        ];
    }
}
