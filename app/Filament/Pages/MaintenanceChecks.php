<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Support\Facades\FilamentView;
use App\Models\Machine;
use Filament\Actions\Action;
use Livewire\Attributes\Computed;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class MaintenanceChecks extends Page
{
  protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
  protected static ?string $navigationLabel = 'Maintenance Checks';
  protected static ?string $title = 'Maintenance Checks';
  protected static ?string $slug = 'maintenance-checks-dashboard';
  protected static ?int $navigationSort = 3;
  protected static ?string $model = null;
  protected static bool $shouldRegisterNavigation = true;

  protected static string $view = 'filament.pages.maintenance-checks';

  public static function getSlug(): string
  {
      return static::$slug ?? 'maintenance-checks';
  }

  public $data = [
      'machine_id' => null,
      'check_date' => null,
      'maintenance_points' => [],
      'notes' => null,
  ];

  protected function getHeaderActions(): array
  {
      return [
          Action::make('createMaintenanceCheck')
              ->label('New Maintenance Check')
              ->icon('heroicon-m-plus')
              ->modalContent(view('filament.pages.partials.maintenance-check-modal', [
                  'data' => $this->data,
              ]))
              ->modalSubmitActionLabel('Save Maintenance Check')
              ->modalWidth('2xl')
              ->action(function (array $data): void {
                  // Validate the data
                  $this->validate([
                      'data.machine_id' => 'required|exists:machines,id',
                      'data.check_date' => 'required|date',
                      'data.maintenance_points' => 'required|array',
                      'data.notes' => 'nullable|string',
                  ]);

                  // Here you would save the maintenance check
                  dd($this->data);
              })
      ];
  }

  #[Computed]
  public function selectedMachine()
  {
      return Machine::find($this->data['machine_id'] ?? null);
  }

  protected function getViewData(): array
  {
      return [
          'machines' => Machine::all(),
      ];
  }
}
