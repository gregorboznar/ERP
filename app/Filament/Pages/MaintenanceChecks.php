<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Machine;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Grid;
use Filament\Forms\Get;
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

    public $currentWeek = 0;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('createMaintenanceCheck')
                ->label(__('messages.new_maintenance_check'))
                ->icon('heroicon-m-plus')
                ->form([
                    Grid::make(2)
                        ->schema([
                            Select::make('machine_id')
                                ->label(__('messages.select_machine'))
                                ->options(Machine::all()->pluck('name', 'id'))
                                ->searchable()
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(fn ($state, callable $set) => $set('maintenance_points', [])),
                            
                            DateTimePicker::make('check_date')
                                ->label(__('messages.check_date'))
                                ->native(false)
                                ->required()
                                ->default(now()),
                        ]),
                    
                    CheckboxList::make('maintenance_points')
                        ->label(__('messages.maintenance_points'))
                        ->options(function (Get $get) {
                            $machineId = $get('machine_id');
                            if (!$machineId) {
                                return [];
                            }
                            
                            $machine = Machine::with('maintenancePoints')->find($machineId);
                            if (!$machine) {
                                return [];
                            }
                            
                            return $machine->maintenancePoints->pluck('name', 'id')->toArray();
                        })
                        ->descriptions(function (Get $get) {
                            $machineId = $get('machine_id');
                            if (!$machineId) {
                                return [];
                            }
                            
                            $machine = Machine::with('maintenancePoints')->find($machineId);
                            if (!$machine) {
                                return [];
                            }
                            
                            return $machine->maintenancePoints->pluck('description', 'id')->toArray();
                        })
                        ->columns(1)
                        ->required()
                        ->helperText(function (Get $get) {
                            $machineId = $get('machine_id');
                            if (!$machineId) {
                                return __('messages.select_machine_to_view_maintenance_points');
                            }
                            return null;
                        }),
                    
                    Textarea::make('notes')
                        ->label(__('messages.notes'))
                        ->placeholder(__('messages.add_any_additional_notes_here'))
                        ->rows(3),
                ])
                ->modalSubmitActionLabel(__('messages.save_maintenance_check'))
                ->modalWidth('3xl')
                ->action(function (array $data): void {
                    $maintenanceCheck = MaintenanceCheck::create([
                        'machine_id' => $data['machine_id'],
                        'date' => $data['check_date'],
                        'notes' => $data['notes'],
                    ]);

                    foreach ($data['maintenance_points'] as $pointId) {
                        $maintenanceCheck->maintenancePoints()->attach($pointId, [
                            'checked' => true
                        ]);
                    }

                    Notification::make()
                        ->success()
                        ->title(__('messages.saved'))
                        ->body(__('messages.maintenance_check_saved_successfully'))
                        ->send();
                })
        ];
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
                    ->form([
                        Grid::make(2)
                            ->schema([
                                Select::make('machine_id')
                                    ->label(__('messages.select_machine'))
                                    ->options(Machine::all()->pluck('name', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('maintenance_points', [])),
                                
                                DateTimePicker::make('date')
                                    ->label(__('messages.check_date'))
                                    ->required(),
                            ]),
                        
                        CheckboxList::make('maintenance_points')
                            ->label(__('messages.maintenance_points'))
                            ->options(function (Get $get) {
                                $machineId = $get('machine_id');
                                if (!$machineId) {
                                    return [];
                                }
                                
                                $machine = Machine::with('maintenancePoints')->find($machineId);
                                if (!$machine) {
                                    return [];
                                }
                                
                                return $machine->maintenancePoints->pluck('name', 'id')->toArray();
                            })
                            ->descriptions(function (Get $get) {
                                $machineId = $get('machine_id');
                                if (!$machineId) {
                                    return [];
                                }
                                
                                $machine = Machine::with('maintenancePoints')->find($machineId);
                                if (!$machine) {
                                    return [];
                                }
                                
                                return $machine->maintenancePoints->pluck('description', 'id')->toArray();
                            })
                            ->columns(1)
                            ->required()
                            ->helperText(function (Get $get) {
                                $machineId = $get('machine_id');
                                if (!$machineId) {
                                    return __('messages.select_machine_to_view_maintenance_points');
                                }
                                return null;
                            }),
                        
                        Textarea::make('notes')
                            ->label(__('messages.notes'))
                            ->placeholder(__('messages.add_any_additional_notes_here'))
                            ->rows(3),
                    ])
                    ->fillForm(function (MaintenanceCheck $record): array {
                        $checkedPoints = $record->maintenancePoints()
                            ->wherePivot('checked', true)
                            ->pluck('maintenance_points.id')
                            ->toArray();
                        
                        return [
                            'machine_id' => $record->machine_id,
                            'date' => $record->date,
                            'maintenance_points' => $checkedPoints,
                            'notes' => $record->notes,
                        ];
                    })
                    ->modalSubmitActionLabel(__('messages.update_maintenance_check'))
                    ->modalWidth('3xl')
                    ->action(function (MaintenanceCheck $record, array $data): void {
                        $record->update([
                            'machine_id' => $data['machine_id'],
                            'date' => $data['date'],
                            'notes' => $data['notes'],
                        ]);

                        $record->maintenancePoints()->detach();

                        foreach ($data['maintenance_points'] as $pointId) {
                            $record->maintenancePoints()->attach($pointId, [
                                'checked' => true
                            ]);
                        }

                        Notification::make()
                            ->success()
                            ->title(__('messages.updated'))
                            ->body(__('messages.maintenance_check_updated_successfully'))
                            ->send();
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
