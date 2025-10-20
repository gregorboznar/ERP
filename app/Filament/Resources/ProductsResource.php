<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Schemas\Components\Grid;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\ProductsResource\Pages\ListProducts;
use App\Filament\Resources\ProductsResource\Pages\ViewProducts;
use App\Filament\Resources\ProductsResource\Pages\TechnologicalRegulations;
use App\Filament\Resources\ProductsResource\Pages\ConfirmationCompliance;
use App\Filament\Resources\ProductsResource\Pages\ProductMeasurementCharacteristics;
use App\Filament\Resources\ProductsResource\Pages\ProductVisualCharacteristics;
use App\Filament\Resources\ProductsResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Navigation\NavigationItem;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductsResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string | \BackedEnum | null $navigationIcon = 'phosphor-factory';

    public static function getPluralModelLabel(): string
    {
        return __('messages.products');
    }

    public static function getNavigationLabel(): string
    {
        return trans('messages.products');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label(__('messages.name'))->required(),
                TextInput::make('code')->label(__('messages.code'))->required(),
                TextInput::make('nest_number')->label(__('messages.nest_number'))->required(),
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
            ->recordActions([
                EditAction::make()
                    ->label(trans('messages.edit'))
                    ->modalHeading(__('messages.edit_product'))
                    ->modalButton(__('messages.save_changes'))
                    ->modalCancelActionLabel(__('messages.cancel'))
                    ->modalWidth('3xl')
                    ->schema([
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
            'index' => ListProducts::route('/'),
            'view' => ViewProducts::route('/{record}'),
            'technological-regulations' => TechnologicalRegulations::route('/{record}/technological-regulations'),
            'confirmation-compliance' => ConfirmationCompliance::route('/{record}/confirmation-compliance'),
            'measurement-characteristics' => ProductMeasurementCharacteristics::route('/{record}/measurement-characteristics'),
            'visual-characteristics' => ProductVisualCharacteristics::route('/{record}/visual-characteristics'),
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
                ->url(fn() => static::getUrl('view', ['record' => $record]))
                ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.products.view')),

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

            NavigationItem::make('measurement-characteristics')
                ->label(__('messages.measurement_characteristics'))
                ->icon('heroicon-o-calculator')
                ->url(fn() => static::getUrl('measurement-characteristics', ['record' => $record]))
                ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.products.measurement-characteristics')),

            NavigationItem::make('visual-characteristics')
                ->label(__('messages.visual_characteristics'))
                ->icon('heroicon-o-eye')
                ->url(fn() => static::getUrl('visual-characteristics', ['record' => $record]))
                ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.products.visual-characteristics')),
        ];
    }
}
