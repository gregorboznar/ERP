<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MachinesResource\Pages;
use App\Filament\Resources\MachinesResource\RelationManagers;
use App\Filament\Resources\MachinesResource\RelationManagers\MaintenancePointsRelationManager;
use App\Models\Machine;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;

class MachinesResource extends Resource
{
    protected static ?string $model = Machine::class;

      public static function getPluralModelLabel(): string
    {
        return __('messages.machines');
    }

    public static function getNavigationLabel(): string
    {
        return trans('messages.machines');
    }



    protected static ?string $navigationIcon = 'heroicon-o-cog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label(__('messages.name')),
                TextInput::make('machine_type')->label(__('messages.machine_type')),
                TextInput::make('type')->label(__('messages.type')),
                DatePicker::make('year_of_manufacture')
                    ->native(false)
                    ->label(__('messages.year_of_manufacture'))
                    ->displayFormat('Y')
                    ->maxDate(now())
                    ->placeholder('Select year'),
                TextInput::make('manufacturer')->label(__('messages.manufacturer')),
                TextInput::make('inventory_number')->label(__('messages.inventory_number')),
               /*  DatePicker::make('control_period'), */
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name') ->label(__('messages.name')),
                TextColumn::make('machine_type') ->label(__('messages.machine_type')),
                TextColumn::make('type') ->label(__('messages.type')),
                TextColumn::make('year_of_manufacture')->date('Y'),
                TextColumn::make('manufacturer') ->label(__('messages.manufacturer')),
                TextColumn::make('inventory_number') ->label(__('messages.inventory_number')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
              
            ]);
    }

    public static function getRelations(): array
    {
        return [
            MaintenancePointsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMachines::route('/'),
            'create' => Pages\CreateMachines::route('/create'),
            'edit' => Pages\EditMachines::route('/{record}/edit'),
        ];
    }
}
