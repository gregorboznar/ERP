<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterialReceiptResource\Pages;
use App\Models\MaterialReceipt;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\NumberColumn;
use Filament\Tables\Columns\DateColumn;
use Illuminate\Support\Facades\Auth;

class MaterialReceiptResource extends Resource
{



    protected static ?string $navigationIcon = 'carbon-receipt';

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
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([

                Forms\Components\DatePicker::make('delivery_date')
                    ->label(__('messages.delivery_date'))
                    ->native(false)
                    ->closeOnDateSelection()
                    ->required(),
                Forms\Components\TextInput::make('delivery_note_number')
                    ->label(__('messages.delivery_note_number'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('batch_number')
                    ->label(__('messages.batch_number'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('weight')
                    ->label(__('messages.weight'))
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('total')
                    ->label(__('messages.total_packages'))
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('material_id')
                    ->label(__('messages.material'))
                    ->relationship('material', 'title')
                    ->native(false)
                    ->required(),
                Forms\Components\Hidden::make('user_id')
                    ->default(fn() => Auth::id())
                    ->required(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
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
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil-square')
                    ->label('')
                    ->modalHeading(__('messages.edit_material_receipt'))
                    ->modalButton(__('messages.save_changes'))
                    ->modalWidth('3xl')
                    ->form([
                        Forms\Components\Grid::make(2) // 2 columns in a row
                            ->schema([

                                Forms\Components\DatePicker::make('delivery_date')
                                    ->label(__('messages.delivery_date'))
                                    ->native(false)
                                    ->closeOnDateSelection()
                                    ->required(),
                                Forms\Components\TextInput::make('delivery_note_number')
                                    ->label(__('messages.delivery_note_number'))
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('batch_number')
                                    ->label(__('messages.batch_number'))
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('weight')
                                    ->label(__('messages.weight'))
                                    ->required()
                                    ->numeric(),
                                Forms\Components\TextInput::make('total')
                                    ->label(__('messages.total_packages'))
                                    ->required()
                                    ->numeric(),
                                Forms\Components\Select::make('material_id')
                                    ->label(__('messages.material'))
                                    ->relationship('material', 'title')
                                    ->native(false)
                                    ->required(),
                            ]),
                        Forms\Components\Hidden::make('user_id')
                            ->default(fn() => Auth::id())
                            ->required(),
                    ]),
                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->label('')
                    ->modalHeading(__('messages.delete_material_receipt'))
                    ->modalDescription(__('messages.delete_material_receipt_confirmation'))
                    ->modalSubmitActionLabel(__('messages.confirm'))
                    ->modalCancelActionLabel(__('messages.cancel'))
                    ->modalWidth('md'),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMaterialReceipts::route('/'),
        ];
    }
}
