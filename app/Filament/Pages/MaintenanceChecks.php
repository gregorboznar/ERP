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
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

use App\Models\MaintenanceCheck;


class MaintenanceChecks extends Page implements HasTable
{
    use InteractsWithTable;

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

    public $editingRecord = null;

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

                    $this->resetData();
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
     
        if (!$this->editingRecord || $this->editingRecord->machine_id != $value) {
            $this->data['maintenance_points'] = [];
            $this->reset(['data.maintenance_points']);
        }
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

    public function loadRecordData(MaintenanceCheck $record)
    {
        $this->editingRecord = $record;
        
        // Handle date conversion safely
        $dateValue = $record->date;
        if (is_string($dateValue)) {
            $dateValue = \Carbon\Carbon::parse($dateValue);
        }
        
        $this->data = [
            'machine_id' => $record->machine_id,
            'check_date' => $dateValue ? $dateValue->format('Y-m-d\TH:i') : null,
            'maintenance_points' => [],
            'notes' => $record->notes,
        ];

        foreach ($record->maintenancePoints as $point) {
            $this->data['maintenance_points'][$point->id] = $point->pivot->checked;
        }
    }

    public function resetData()
    {
        $this->editingRecord = null;
        $this->data = [
            'machine_id' => null,
            'check_date' => null,
            'maintenance_points' => [],
            'notes' => null,
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(MaintenanceCheck::query()->with(['machine', 'maintenancePoints']))
            ->columns([
                TextColumn::make('date')
                    ->label(__('messages.date'))
                    ->date()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('machine.name')
                    ->label(__('messages.machine'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('maintenancePoints')
                    ->label(__('messages.maintenance_points'))
                    ->formatStateUsing(function ($record) {
                        $checkedCount = $record->maintenancePoints->where('pivot.checked', true)->count();
                        $totalCount = $record->maintenancePoints->count();
                        return "{$checkedCount}/{$totalCount}";
                    })
                    ->badge()
                    ->color(function ($record) {
                        $checkedCount = $record->maintenancePoints->where('pivot.checked', true)->count();
                        $totalCount = $record->maintenancePoints->count();
                        if ($totalCount === 0) return 'gray';
                        return $checkedCount === $totalCount ? 'success' : 'warning';
                    }),
                TextColumn::make('notes')
                    ->label(__('messages.notes'))
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),
                TextColumn::make('created_at')
                    ->label(__('messages.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('machine_id')
                    ->label(__('messages.machine'))
                    ->relationship('machine', 'name'),
                Filter::make('date')
                    ->form([
                        DatePicker::make('date_from')
                            ->label(__('messages.date_from')),
                        DatePicker::make('date_until')
                            ->label(__('messages.date_until')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_from'],
                                function (Builder $query, $date): Builder {
                                    return $query->whereDate('date', '>=', $date);
                                },
                            )
                            ->when(
                                $data['date_until'],
                                function (Builder $query, $date): Builder {
                                    return $query->whereDate('date', '<=', $date);
                                },
                            );
                    }),
            ])
            ->actions([
                ViewAction::make()
                    ->modalContent(function (MaintenanceCheck $record) {
                        return view('filament.pages.partials.maintenance-check-view', [
                            'record' => $record,
                        ]);
                    })
                    ->modalWidth('3xl'),
                EditAction::make()
                    ->modalContent(function (MaintenanceCheck $record) {
                        $this->loadRecordData($record);
                        return view('filament.pages.partials.maintenance-check-modal', [
                            'data' => $this->data,
                        ]);
                    })
                    ->modalSubmitActionLabel(__('messages.update_maintenance_check'))
                    ->modalWidth('3xl')
                    ->action(function (MaintenanceCheck $record): void {
                        $this->validate([
                            'data.machine_id' => 'required|exists:machines,id',
                            'data.check_date' => 'required|date',
                            'data.maintenance_points' => 'required|array',
                            'data.notes' => 'nullable|string',
                        ]);

                        $record->update([
                            'machine_id' => $this->data['machine_id'],
                            'date' => $this->data['check_date'],
                            'notes' => $this->data['notes'],
                        ]);

                        $record->maintenancePoints()->detach();

                        foreach ($this->data['maintenance_points'] as $pointId => $checked) {
                            if ($checked) {
                                $record->maintenancePoints()->attach($pointId, [
                                    'checked' => true
                                ]);
                            }
                        }

                        Notification::make()
                            ->success()
                            ->title(__('messages.updated'))
                            ->body(__('messages.maintenance_check_updated_successfully'))
                            ->send();

                        $this->resetData();
                    }),
                DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
          /*           Tables\Actions\DeleteBulkAction::make(), */
                ]),
            ])
            ->defaultSort('date', 'desc');
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
