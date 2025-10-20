<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\ConfirmationComplianceResource\Pages\ListConfirmationCompliances;
use App\Filament\Resources\ConfirmationComplianceResource\Pages\CreateConfirmationCompliance;
use App\Filament\Resources\ConfirmationComplianceResource\Pages\EditConfirmationCompliance;
use App\Filament\Resources\ConfirmationComplianceResource\Pages\ViewConfirmationCompliance;
use App\Filament\Resources\ConfirmationComplianceResource\Pages\VisualCharacteristics;
use App\Filament\Resources\ConfirmationComplianceResource\Pages\MeasurementCharacteristics;
use Filament\Pages\Page;
use App\Filament\Resources\ConfirmationComplianceResource\Pages;
use App\Models\ConfirmationCompliance;
use Filament\Resources\Resource;
use Filament\Tables\Table;


class ConfirmationComplianceResource extends Resource
{
    protected static ?string $model = ConfirmationCompliance::class;

    protected static string | \BackedEnum | null $navigationIcon = 'phosphor-check-circle';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
            ->recordActions([
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
            'index' => ListConfirmationCompliances::route('/'),
            'create' => CreateConfirmationCompliance::route('/create'),
            'edit' => EditConfirmationCompliance::route('/{record}/edit'),
            'view' => ViewConfirmationCompliance::route('/{record}'),
            'visual-characteristics' => VisualCharacteristics::route('/{record}/visual-characteristics'),
            'measurement-characteristics' => MeasurementCharacteristics::route('/{record}/measurement-characteristics'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return [
            'view' => ViewConfirmationCompliance::class,
            'visual-characteristics' => VisualCharacteristics::class,
            'measurement-characteristics' => MeasurementCharacteristics::class,
        ];
    }
}
