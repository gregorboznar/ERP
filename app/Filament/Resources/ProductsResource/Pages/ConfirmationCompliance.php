<?php

namespace App\Filament\Resources\ProductsResource\Pages;

use App\Filament\Resources\ProductsResource;
use Filament\Resources\Pages\Page;
use Filament\Navigation\NavigationItem;
use Filament\Pages\SubNavigationPosition;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use App\Models\ConfirmationCompliance as ConfirmationComplianceModel;
use App\Models\VisualCharacteristic;
use App\Models\MeasurementCharacteristic;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\View;
use Filament\Actions\CreateAction;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\Alignment;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Livewire\ConfirmationComplianceForm;
use App\Models\Product;
use Illuminate\Support\Facades\URL;

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


  public function getTitle(): string
  {
    return __('messages.confirmation_compliance_for') . ' ' . Product::find($this->record)->name;
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
    return ProductsResource::generateNavigation($this->record);
  }

  public function getBreadcrumbs(): array
  {
    $product = Product::find($this->record);

    return [
      ProductsResource::getUrl() => __('messages.products'),
      URL::current() => __('messages.confirmation_compliance'),
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
        TextColumn::make('user.name')
          ->label(__('messages.user'))
          ->sortable(),

        IconColumn::make('correct_technological_parameters')
          ->label(__('messages.correct_technological_parameters_plural'))
          ->sortable()
          ->icon(fn(string $state): string => match ($state) {
            '0' => 'heroicon-o-x-circle',
            default => 'heroicon-o-check-circle'
          })
          ->color(fn(string $state): string => match ($state) {
            '0' => 'danger',
            default => 'success'
          }),
        TextColumn::make('created_at')
          ->label(__('messages.created_at'))
          ->dateTime('d.m.Y H:i')
          ->sortable(),
      ])
      ->filters([
        //
      ])
      ->actions([
        EditAction::make()
          ->label(__('messages.edit')),
        DeleteAction::make()
          ->label(__('messages.delete'))
          ->modalHeading(__('messages.delete_confirmation_compliance'))
          ->modalDescription(__('messages.delete_confirmation_compliance_confirmation'))
          ->modalSubmitActionLabel(__('messages.confirm_delete'))
          ->modalCancelActionLabel(__('messages.cancel'))
          ->successNotificationTitle(__('messages.deleted')),
      ])

      ->headerActions([
        Action::make('new')
          ->label(__('messages.new_confirmation_compliance_button'))
          ->modalHeading(__('messages.new_confirmation_compliance_title'))
          ->icon('heroicon-m-plus')
          ->form([
            View::make('filament.pages.partials.confirmation-compliance-modal')
              ->viewData(['record' => $this->record])
          ])
          ->modalSubmitAction(false)
          ->modalCancelAction(false)
          ->modalWidth('95rem')
          ->modalAlignment(Alignment::Center),
      ]);
  }
}
