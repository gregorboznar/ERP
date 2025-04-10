<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductsResource\Pages;
use App\Filament\Resources\ProductsResource\RelationManagers;
use App\Models\Products;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Product;
use Filament\Navigation\NavigationItem;

class ProductsResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'phosphor-factory';


    public static function getPluralModelLabel(): string
    {
        return __('messages.products');
    }


    public static function getNavigationLabel(): string
    {
        return trans('messages.products');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('code')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('messages.title')),
                Tables\Columns\TextColumn::make('code')->label(__('messages.code')),
                Tables\Columns\TextColumn::make('nest_number')->label(__('messages.nest_number')),

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil-square')
                    ->label('')
                    ->modalHeading(__('messages.edit_product'))
                    ->modalButton(__('messages.save_changes'))
                    ->modalWidth('3xl')
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label(__('messages.name'))
                                    ->required(),
                                Forms\Components\TextInput::make('code')
                                    ->label(__('messages.code'))
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('nest_number')
                                    ->label(__('messages.nest_number'))
                                    ->required()
                                    ->maxLength(255),
                            ]),

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
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'view' => Pages\ViewProducts::route('/{record}'),
            'technological-regulations' => Pages\TechnologicalRegulations::route('/{record}/technological-regulations'),
            'confirmation-compliance' => Pages\ConfirmationCompliance::route('/{record}/confirmation-compliance'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function generateNavigation($record): array
    {
        return [
            NavigationItem::make('view')
                ->label(__('messages.view'))
                ->icon('heroicon-o-eye')
                ->url(fn() => static::getUrl('view', ['record' => $record])),

            NavigationItem::make('technological-regulations')
                ->label(__('messages.technological_regulations'))
                ->icon('heroicon-o-document-text')
                ->url(fn() => static::getUrl('technological-regulations', ['record' => $record]))
                ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.products.technological-regulations')),

            NavigationItem::make('confirmation-compliance')
                ->label(__('messages.confirmation_compliance'))
                ->icon('heroicon-o-check-circle')
                ->url(fn() => static::getUrl('confirmation-compliance', ['record' => $record]))
                ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.products.confirmation-compliance')),

        ];
    }
}
