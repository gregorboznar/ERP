<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductsResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Navigation\NavigationItem;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                TextInput::make('name')->required(),
                TextInput::make('code')->required(),
                TextInput::make('nest_number')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('messages.title')),
                TextColumn::make('code')->label(__('messages.code')),
                TextColumn::make('nest_number')->label(__('messages.nest_number')),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make()
                    ->label(trans('messages.edit'))
                    ->modalHeading(__('messages.edit_product'))
                    ->modalButton(__('messages.save_changes'))
                    ->modalCancelActionLabel(__('messages.cancel'))
                    ->modalWidth('3xl')
                    ->form([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('messages.name'))
                                    ->required(),
                                TextInput::make('code')
                                    ->label(__('messages.code'))
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('nest_number')
                                    ->label(__('messages.nest_number'))
                                    ->required()
                                    ->maxLength(255),
                            ]),
                    ]),
                DeleteAction::make()
                    ->label(__('messages.delete'))
                    ->modalHeading(__('messages.delete_product'))

                    ->modalDescription(__('messages.delete_product_confirmation'))
                    ->modalSubmitActionLabel(__('messages.confirm_delete'))
                    ->modalCancelActionLabel(__('messages.cancel'))
                    ->modalWidth('md'),
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
