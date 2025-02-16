<?php

namespace App\Filament\Resources\ProductsResource\Pages;

use App\Filament\Resources\ProductsResource;
use Filament\Resources\Pages\Page;
use Filament\Navigation\NavigationItem;
use Filament\Pages\SubNavigationPosition;
use Filament\Tables\Table;
use Filament\Tables;
use App\Models\ConfirmationCompliance as ConfirmationComplianceModel;
use App\Models\VisualCharacteristic;
use App\Models\MeasurementCharacteristic;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Actions\CreateAction;
use Filament\Support\Enums\ActionSize;
use Illuminate\Support\Collection;
use Filament\Forms\Components\View;

class ConfirmationCompliance extends Page implements HasTable
{
  use InteractsWithTable;

  protected static string $resource = ProductsResource::class;

  protected static string $view = 'filament.resources.products-resource.pages.confirmation-compliance';

  protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

  public ?string $record = null;

  public function mount(int|string $record): void
  {
    $this->record = $record;
  }

  protected function getVisualCharacteristics(): Collection
  {
    return VisualCharacteristic::query()
      ->whereIn('id', function ($query) {
        $query->select('visual_characteristic_id')
          ->from('product_visual_characteristics')
          ->where('product_id', $this->record);
      })
      ->get();
  }

  protected function getMeasurementCharacteristics(): Collection
  {
    return MeasurementCharacteristic::query()
      ->whereIn('id', function ($query) {
        $query->select('measurement_characteristic_id')
          ->from('product_measurement_characteristics')
          ->where('product_id', $this->record);
      })
      ->get();
  }

  public function getSubNavigation(): array
  {
    return [
      NavigationItem::make('view')
        ->label('Details')
        ->icon('heroicon-o-eye')
        ->url(fn() => ProductsResource::getUrl('view', ['record' => $this->record])),

      NavigationItem::make('technological-regulations')
        ->label('Technological Regulations')
        ->icon('heroicon-o-document-text')
        ->url(fn() => ProductsResource::getUrl('technological-regulations', ['record' => $this->record])),

      NavigationItem::make('confirmation-compliance')
        ->label('Confirmation Compliance')
        ->icon('heroicon-o-check-circle')
        ->url(fn() => ProductsResource::getUrl('confirmation-compliance', ['record' => $this->record]))
        ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.products.confirmation-compliance', ['record' => $this->record])),
    ];
  }

  public function table(Table $table): Table
  {
    return $table
      ->query(
        ConfirmationComplianceModel::query()
          ->where('product_id', $this->record)
      )
      ->columns([

        Tables\Columns\TextColumn::make('created_at')
          ->label('Created At')
          ->dateTime()
          ->sortable(),
        Tables\Columns\TextColumn::make('updated_at')
          ->label('Updated At')
          ->dateTime()
          ->sortable(),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
      ])
      ->headerActions([
        Tables\Actions\CreateAction::make()
          ->label('New Confirmation Compliance')
          ->icon('heroicon-m-plus')
          ->size(ActionSize::Large)
          ->createAnother(false)
          ->form([

            Forms\Components\Section::make('Visual Characteristics')
              ->schema([
                View::make('filament.pages.partials.visual-characteristics-form')
                  ->viewData([
                    'characteristics' => $this->getVisualCharacteristics(),
                  ])
              ]),
            Forms\Components\Section::make('Measurement Characteristics')
              ->schema([
                View::make('filament.pages.partials.measurement-characteristics-form')
                  ->viewData([
                    'characteristics' => $this->getMeasurementCharacteristics(),
                  ])
              ]),
            Forms\Components\Hidden::make('product_id')
              ->default($this->record),

          ])
      ]);
  }
}
