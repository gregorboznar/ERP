<?php

namespace App\Filament\Resources\ProductsResource\Pages;

use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Actions\DetachAction;
use Filament\Actions\Action;
use App\Filament\Resources\ProductsResource;
use App\Models\VisualCharacteristic;
use App\Models\Product;
use Filament\Resources\Pages\Page;
use Filament\Navigation\NavigationItem;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Alignment;
use Illuminate\Support\Facades\URL;

class ProductVisualCharacteristics extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = ProductsResource::class;

    protected string $view = 'filament.resources.products-resource.pages.product-visual-characteristics';

    protected static ?\Filament\Pages\Enums\SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public ?string $record = null;

    public function mount(int|string $record): void
    {
        $this->record = $record;
    }

    public function getTitle(): string
    {
        return __('messages.product_visual_characteristics') . ' - ' . Product::find($this->record)->name;
    }

    public function getSubNavigation(): array
    {
        return ProductsResource::generateNavigation($this->record);
    }

    public function getBreadcrumbs(): array
    {
        $product = Product::find($this->record);

        return [
            ProductsResource::getUrl() => __('messages.products'),
            URL::current() => __('messages.visual_characteristics'),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                VisualCharacteristic::query()
                    ->whereHas('products', function (Builder $query) {
                        $query->where('product_id', $this->record);
                    })
            )
            ->columns([
                TextColumn::make('name')
                    ->label(__('messages.name'))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                DetachAction::make()
                    ->label(__('messages.delete'))
                    ->modalHeading(__('messages.delete_visual_characteristic'))
                    ->modalSubmitActionLabel(__('messages.delete'))
                    ->modalCancelActionLabel(__('messages.cancel'))
                    ->successNotificationTitle(__('messages.deleted'))
                    ->action(function (VisualCharacteristic $record) {
                        $product = Product::find($this->record);
                        $product->visualCharacteristics()->detach($record->id);
                    }),
            ])
            ->headerActions([
                Action::make('attach')
                    ->label(__('messages.add_visual_characteristic'))
                    ->modalHeading(__('messages.add_visual_characteristic'))
                    ->icon('heroicon-m-plus')
                    ->schema([
                        Select::make('visual_characteristic_id')
                            ->label(__('messages.visual_characteristics'))
                            ->options(function () {
                                $product = Product::find($this->record);
                                $attachedIds = $product->visualCharacteristics()->pluck('visual_characteristic_id');
                                
                                return VisualCharacteristic::whereNotIn('id', $attachedIds)
                                    ->pluck('name', 'id');
                            })
                            ->searchable()
                            ->required()
                            ->multiple()
                    ])
                    ->action(function (array $data) {
                        $product = Product::find($this->record);
                        $product->visualCharacteristics()->attach($data['visual_characteristic_id']);
                    })
                    ->successNotificationTitle(__('messages.attached'))
                    ->modalSubmitActionLabel(__('messages.attach'))
                    ->modalCancelActionLabel(__('messages.cancel'))
                    ->modalWidth('md')
                    ->modalAlignment(Alignment::Center),
            ])
            ->emptyStateHeading(__('messages.no_visual_characteristics'))
            ->emptyStateDescription('')
            ->emptyStateIcon('heroicon-o-eye');
    }
}
