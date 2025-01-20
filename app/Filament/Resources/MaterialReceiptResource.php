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
    protected static ?string $model = MaterialReceipt::class;

    protected static ?string $navigationIcon = 'carbon-receipt';

    public static function getNavigationLabel(): string
    {
        return __('messages.material_receipts');
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Inventory';
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('delivery_date')->native(false)->closeOnDateSelection()
                    ->required(),
                Forms\Components\TextInput::make('delivery_note_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('batch_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('weight')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('total')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('material_id')
                    ->relationship('material', 'title')->native(false)
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
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('delivery_date')->date()->sortable(),
                TextColumn::make('delivery_note_number')->sortable()->searchable(),
                TextColumn::make('batch_number')->sortable()->searchable(),
                TextColumn::make('weight')->numeric()->sortable(),
                TextColumn::make('total')->numeric()->sortable(),
                TextColumn::make('user.name')->sortable()->searchable(),
                TextColumn::make('material.title')->sortable()->searchable(),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Edit Material Receipt')
                    ->modalButton('Save Changes')
                    ->modalWidth('3xl')
                    ->form([
                        Forms\Components\Grid::make(2) // 2 columns in a row
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\DatePicker::make('delivery_date')->native(false)->closeOnDateSelection()
                                    ->required(),
                                Forms\Components\TextInput::make('delivery_note_number')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('batch_number')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('weight')
                                    ->required()
                                    ->numeric(),
                                Forms\Components\TextInput::make('total')
                                    ->required()
                                    ->numeric(),
                                Forms\Components\Select::make('material_id')
                                    ->relationship('material', 'title')->native(false)
                                    ->required(),
                            ]),
                        Forms\Components\Hidden::make('user_id')
                            ->default(fn() => Auth::id())
                            ->required(),
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMaterialReceipts::route('/'),
        ];
    }
}
