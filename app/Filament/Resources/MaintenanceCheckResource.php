<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaintenanceCheckResource\Pages;
use App\Filament\Resources\MaintenanceCheckResource\RelationManagers;
use App\Models\MaintenanceCheck;
use App\Models\Machine;
use App\Models\MaintenancePoint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class MaintenanceCheckResource extends Resource
{
    protected static ?string $model = MaintenanceCheck::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('date')
                    ->required()
                    ->native(false)
                    ->label(__('messages.date')),
                Select::make('machine_id')
                    ->relationship('machine', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label(__('messages.machine')),
                Select::make('maintenance_point_id')
                    ->relationship('maintenancePoint', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label(__('messages.maintenance_point')),
                Toggle::make('completed')
                    ->required()
                    ->label(__('messages.completed')),
                Textarea::make('notes')
                    ->maxLength(65535)
                    ->label(__('messages.notes'))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->date()
                    ->sortable()
                    ->label(__('messages.date')),
                TextColumn::make('machine.name')
                    ->sortable()
                    ->searchable()
                    ->label(__('messages.machine')),
                TextColumn::make('maintenancePoint.name')
                    ->sortable()
                    ->searchable()
                    ->label(__('messages.maintenance_point')),
                ToggleColumn::make('completed')
                    ->sortable()
                    ->label(__('messages.completed')),
                TextColumn::make('notes')
                    ->limit(50)
                    ->label(__('messages.notes'))
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => Pages\ListMaintenanceChecks::route('/'),
        ];
    }
}
