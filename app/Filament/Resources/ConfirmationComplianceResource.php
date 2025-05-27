<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConfirmationComplianceResource\Pages;
use App\Models\ConfirmationCompliance;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;


class ConfirmationComplianceResource extends Resource
{
    protected static ?string $model = ConfirmationCompliance::class;

    protected static ?string $navigationIcon = 'phosphor-check-circle';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
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
                EditAction::make()
                    ->label(__('messages.edit')),
                DeleteAction::make()
                    ->label(__('messages.delete'))
                    ->modalHeading(__('messages.delete_confirmation_compliance'))
                    ->modalDescription(__('messages.delete_confirmation_compliance_confirmation'))
                    ->modalSubmitActionLabel(__('messages.confirm_delete'))
                    ->modalCancelActionLabel(__('messages.cancel'))
                    ->successNotificationTitle(__('messages.deleted')),
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
