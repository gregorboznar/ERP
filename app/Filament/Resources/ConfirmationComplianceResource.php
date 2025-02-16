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
use Filament\Resources\Pages\Page;

class ConfirmationComplianceResource extends Resource
{
    protected static ?string $model = ConfirmationCompliance::class;

    protected static ?string $navigationIcon = 'phosphor-check-circle';

    protected static ?string $navigationGroup = 'Quality Control';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('Quality Control');
    }

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
            'index' => Pages\ListConfirmationCompliances::route('/'),
            'create' => Pages\CreateConfirmationCompliance::route('/create'),
            'edit' => Pages\EditConfirmationCompliance::route('/{record}/edit'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\ListConfirmationCompliances::class,
            Pages\CreateConfirmationCompliance::class,
            Pages\EditConfirmationCompliance::class,
        ]);
    }
}
