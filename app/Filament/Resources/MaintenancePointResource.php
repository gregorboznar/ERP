<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaintenancePointResource\Pages;
use App\Models\MaintenancePoint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;


class MaintenancePointResource extends Resource
{
    protected static ?string $model = MaintenancePoint::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static bool $shouldRegisterNavigation = false;

    public static function getPluralModelLabel(): string
    {
        return __('messages.daily_maintenance_activity');
    }

    public static function getNavigationLabel(): string
    {
        return trans('messages.daily_maintenance_activity');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->label(__('messages.name'))
                            ->maxLength(255),
                        TextInput::make('description')
                            ->required()
                            ->label(__('messages.description'))
                            ->maxLength(255),

                        TextInput::make('location')
                            ->required()
                            ->label(__('messages.location'))
                            ->maxLength(255),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('messages.name'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('description')
                    ->label(__('messages.description'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('location')
                    ->label(__('messages.location'))
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()
                    ->label(__('messages.edit')),
                DeleteAction::make()
                    ->label(__('messages.delete'))
                    ->modalHeading(__('messages.delete_maintenance_point'))
                    ->modalDescription(__('messages.delete_maintenance_point_confirmation'))
                    ->modalDescription(__('messages.delete_maintenance_point_confirmation'))
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
            'index' => Pages\ListMaintenancePoints::route('/'),
            'edit' => Pages\EditMaintenancePoint::route('/{record}/edit'),
        ];
    }
}
