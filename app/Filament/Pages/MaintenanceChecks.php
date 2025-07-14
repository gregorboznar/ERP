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

use App\Models\MaintenanceCheck;


class MaintenanceChecks extends Page
{

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Dnevna kontrola';
    protected static ?string $title = 'Dnevna kontrola';
    protected static ?string $slug = 'maintenance-checks-dashboard';
    protected static ?int $navigationSort = 3;
    protected static ?string $model = null;
    protected static bool $shouldRegisterNavigation = true;

    protected static string $view = 'filament.pages.maintenance-checks';

    public static function getNavigationLabel(): string
    {
        return __('messages.daily_check');
    }
    public static function getNavigationGroup(): ?string
    {
        return 'Operativa';
    }
    public static function getPluralModelLabel(): string
    {
        return __('messages.daily_check');
    }


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

    public $currentWeek = 0;

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
                ->label(__('messages.new_maintenance_check'))
                ->icon('heroicon-m-plus')
                ->modalContent(view('filament.pages.partials.maintenance-check-modal', [
                    'data' => $this->data,
                ]))
                ->modalSubmitActionLabel(__('messages.save_maintenance_check'))
                ->modalWidth('3xl')
                ->action(function (array $data): void {
                    $this->validate([
                        'data.machine_id' => 'required|exists:machines,id',
                        'data.check_date' => 'required|date',
                        'data.maintenance_points' => 'required|array',
                        'data.notes' => 'nullable|string',
                    ]);

                    $maintenanceCheck = MaintenanceCheck::create([
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
                        ->title(__('messages.saved'))
                        ->body(__('messages.maintenance_check_saved_successfully'))
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
        $this->reset(['data.maintenance_points']);
        $this->dispatch('$refresh');
    }

    protected function getListeners()
    {
        return [
            'maintenance-points-updated' => '$refresh',
            'machine-selected' => 'handleMachineSelected',
        ];
    }

    public function handleMachineSelected($event)
    {
        $this->data['machine_id'] = $event['machineId'];
        $this->data['maintenance_points'] = [];
        $this->dispatch('$refresh');
    }

    public function nextWeek()
    {
        $this->currentWeek = min($this->currentWeek + 1, 12);
    }

    public function previousWeek()
    {
        $this->currentWeek = max($this->currentWeek - 1, -12);
    }

    public function getWeekDates()
    {
        $startOfWeek = now()->startOfWeek()->addWeeks($this->currentWeek);
        return [
            'start' => $startOfWeek->format('Y-m-d'),
            'end' => $startOfWeek->copy()->endOfWeek()->format('Y-m-d'),
        ];
    }

    protected function getViewData(): array
    {
        $weekDates = $this->getWeekDates();
        $startOfWeek = now()->startOfWeek()->addWeeks($this->currentWeek);
        $endOfWeek = $startOfWeek->copy()->endOfWeek();

        $machines = Machine::with(['maintenancePoints', 'maintenanceChecks' => function ($query) use ($weekDates) {
            $query->whereBetween('date', [$weekDates['start'], $weekDates['end']])
                ->with('maintenancePoints');
        }])->get();

        return [
            'machines' => $machines,
            'currentWeek' => $this->currentWeek,
            'startOfWeek' => $startOfWeek,
            'endOfWeek' => $endOfWeek,
        ];
    }
}
