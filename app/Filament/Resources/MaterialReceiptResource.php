<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\MaterialReceiptResource\Pages\ListMaterialReceipts;
use App\Filament\Resources\MaterialReceiptResource\Pages;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Support\Facades\Auth;

class MaterialReceiptResource extends Resource
{
    protected static string | \BackedEnum | null $navigationIcon = 'carbon-receipt';

    public static function getNavigationLabel(): string
    {
        return __('messages.material_receipt');
    }

    public static function getPluralModelLabel(): string
    {
        return __('messages.material_receipt');
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Operativa';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('delivery_date')
                    ->label(__('messages.delivery_date'))
                    ->native(false)
                    ->closeOnDateSelection()
                    ->required(),
                TextInput::make('delivery_note_number')
                    ->label(__('messages.delivery_note_number'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('batch_number')
                    ->label(__('messages.batch_number'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('weight')
                    ->label(__('messages.weight'))
                    ->required()
                    ->numeric(),
                TextInput::make('total')
                    ->label(__('messages.total_packages'))
                    ->required(),
                Select::make('material_id')
                    ->label(__('messages.material'))
                    ->relationship('material', 'title')
                    ->native(false)
                    ->required(),
                Hidden::make('user_id')
                    ->default(fn() => Auth::id())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('material.title')
                    ->label(__('messages.material'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('delivery_date')
                    ->label(__('messages.delivery_date'))
                    ->date()
                    ->sortable(),
                TextColumn::make('delivery_note_number')
                    ->label(__('messages.delivery_note_number'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('batch_number')
                    ->label(__('messages.batch_number'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('weight')
                    ->label(__('messages.weight'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total')
                    ->label(__('messages.total_packages'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label(__('messages.user'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label(__('messages.created_at'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->recordCheckboxPosition(null)
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make()
                    ->label(__('messages.edit'))
                    ->modalHeading(__('messages.edit_material_receipt'))
                    ->modalButton(__('messages.save_changes'))
                    ->modalCancelActionLabel(__('messages.cancel'))
                    ->modalWidth('3xl'),
                DeleteAction::make()
                    ->label(__('messages.delete'))
                    ->modalHeading(__('messages.delete_material_receipt'))
                    ->modalDescription(__('messages.delete_material_receipt_confirmation'))
                    ->modalSubmitActionLabel(__('messages.confirm_delete'))
                    ->modalCancelActionLabel(__('messages.cancel'))
                    ->modalWidth('md'),
            ])
            ->toolbarActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMaterialReceipts::route('/'),
        ];
    }
}
