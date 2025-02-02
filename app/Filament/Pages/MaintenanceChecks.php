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
use Filament\Notifications\Notification;


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

    public function mount()
    {
        $this->data = [
            'machine_id' => null,
            'check_date' => null,
            'maintenance_points' => [],
            'notes' => null,
        ];
    }

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
                ->modalWidth('3xl')
                ->action(function (array $data): void {
                    $this->validate([
                        'data.machine_id' => 'required|exists:machines,id',
                        'data.check_date' => 'required|date',
                        'data.maintenance_points' => 'required|array',
                        'data.notes' => 'nullable|string',
                    ]);

                    $maintenanceCheck = \App\Models\MaintenanceCheck::create([
                        'machine_id' => $this->data['machine_id'],
                        'date' => $this->data['check_date'],
                        'notes' => $this->data['notes'],
                    ]);

                    foreach ($this->data['maintenance_points'] as $pointId => $checked) {
                        if ($checked) {
                            $maintenanceCheck->maintenancePoints()->attach($pointId, [
                                'checked' => true
                            ]);
                        }
                    }

                    Notification::make()
                        ->success()
                        ->title('Success')
                        ->body('Maintenance check saved successfully')
                        ->send();
                })
        ];
    }

    #[Computed]
    public function selectedMachine()
    {
        if (!isset($this->data['machine_id'])) {
            return null;
        }
        return Machine::with('maintenancePoints')->find($this->data['machine_id']);
    }

    public function updatedDataMachineId($value)
    {
        $this->data['maintenance_points'] = [];
        $this->dispatch('maintenance-points-updated');
    }

    protected function getListeners()
    {
        return [
            'maintenance-points-updated' => '$refresh',
        ];
    }

    protected function getViewData(): array
    {
        return [
            'machines' => Machine::all(),
        ];
    }
}
