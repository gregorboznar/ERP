<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaintenancePointResource\Pages;
use App\Filament\Resources\MaintenancePointResource\RelationManagers;
use App\Models\MaintenancePoint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;

class MaintenancePointResource extends Resource
{
    protected static ?string $model = MaintenancePoint::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListMaintenancePoints::route('/'),
            'edit' => Pages\EditMaintenancePoint::route('/{record}/edit'),
        ];
    }
}
