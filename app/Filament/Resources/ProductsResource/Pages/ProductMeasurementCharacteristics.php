<?php

namespace App\Filament\Resources\ProductsResource\Pages;

use App\Filament\Resources\ProductsResource;
use App\Models\MeasurementCharacteristic;
use App\Models\Product;
use Filament\Resources\Pages\Page;
use Filament\Navigation\NavigationItem;
use Filament\Pages\SubNavigationPosition;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DetachAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Alignment;
use Illuminate\Support\Facades\URL;

class ProductMeasurementCharacteristics extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = ProductsResource::class;

    protected static string $view = 'filament.resources.products-resource.pages.product-measurement-characteristics';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public ?string $record = null;

    public function mount(int|string $record): void
    {
        $this->record = $record;
    }

    public function getTitle(): string
    {
        return __('messages.product_measurement_characteristics') . ' - ' . Product::find($this->record)->name;
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
            URL::current() => __('messages.measurement_characteristics'),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                MeasurementCharacteristic::query()
                    ->whereHas('products', function (Builder $query) {
                        $query->where('product_id', $this->record);
                    })
            )
            ->columns([
                TextColumn::make('name')
                    ->label(__('messages.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('unit')
                    ->label(__('messages.unit'))
                    ->sortable(),
                TextColumn::make('nominal_value')
                    ->label(__('messages.nominal_value'))
                    ->sortable(),
                TextColumn::make('tolerance')
                    ->label(__('messages.tolerance'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                DetachAction::make()
                    ->label(__('messages.delete'))
                    ->modalHeading(__('messages.delete_measurement_characteristic'))
                    ->modalSubmitActionLabel(__('messages.delete'))
                    ->modalCancelActionLabel(__('messages.cancel'))
                    ->successNotificationTitle(__('messages.deleted'))
                    ->action(function (MeasurementCharacteristic $record) {
                        $product = Product::find($this->record);
                        $product->measurementCharacteristics()->detach($record->id);
                    }),
            ])
            ->headerActions([
                Action::make('attach')
                    ->label(__('messages.attach_measurement_characteristic'))
                    ->modalHeading(__('messages.attach_measurement_characteristic'))
                    ->icon('heroicon-m-plus')
                    ->form([
                        Select::make('measurement_characteristic_id')
                            ->label(__('messages.measurement_characteristics'))
                            ->options(function () {
                                $product = Product::find($this->record);
                                $attachedIds = $product->measurementCharacteristics()->pluck('measurement_characteristic_id');
                                
                                return MeasurementCharacteristic::whereNotIn('id', $attachedIds)
                                    ->pluck('name', 'id');
                            })
                            ->searchable()
                            ->required()
                            ->multiple()
                    ])
                    ->action(function (array $data) {
                        $product = Product::find($this->record);
                        $product->measurementCharacteristics()->attach($data['measurement_characteristic_id']);
                    })
                    ->successNotificationTitle(__('messages.attached'))
                    ->modalSubmitActionLabel(__('messages.attach'))
                    ->modalCancelActionLabel(__('messages.cancel'))
                    ->modalWidth('md')
                    ->modalAlignment(Alignment::Center),
            ])
            ->emptyStateHeading(__('messages.no_measurement_characteristics'))
            ->emptyStateDescription('')
            ->emptyStateIcon('heroicon-o-calculator');
    }
}
