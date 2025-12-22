<?php

namespace App\Filament\Resources\SeriesTenderResource\Pages;

use Filament\Actions\EditAction;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Carbon\Carbon;
use Exception;
use App\Filament\Resources\SeriesTenderResource;
use Filament\Resources\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Models\ProductionOperation;
use Filament\Actions\CreateAction;
use App\Models\SeriesTender;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Support\Exceptions\Halt;
use Filament\Navigation\NavigationItem;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Forms\Form;
use App\Filament\Widgets\MachineTrimmingStatsWidget;

class MachineTrimming extends Page implements HasTable, HasForms
{
  use InteractsWithTable;
  use InteractsWithForms;
  use InteractsWithFormActions;

  protected static string $resource = SeriesTenderResource::class;

  protected string $view = 'filament.resources.series-tender-resource.pages.machine-trimming';

  public ?string $record = null;

  public function getTitle(): string
  {
    return __('messages.series_machine_trimming') . ' ' . SeriesTender::find($this->record)->series_number;
  }

  public function mount(int|string $record): void
  {
    $this->record = $record;
  }

  public function getSubNavigation(): array
  {
    return SeriesTenderResource::generateNavigation($this->record);
  }

  public function table(Table $table): Table
  {
    return $table
      ->query(
        ProductionOperation::query()
          ->where('series_tender_id', $this->record)
          ->where('operation_type', ProductionOperation::TYPE_MACHINE_TRIMMING)
      )
      ->defaultSort('date', 'desc')
      ->columns([
        TextColumn::make('date')
          ->label(__('messages.date'))
          ->date('d.m.Y')
          ->sortable(),
        TextColumn::make('start_time')
          ->label(__('messages.start_time'))
          ->time('H:i')
          ->sortable(),
        TextColumn::make('end_time')
          ->label(__('messages.end_time'))
          ->time('H:i')
          ->sortable(),
        TextColumn::make('counter_start')
          ->label(__('messages.counter_start'))
          ->sortable(),
        TextColumn::make('counter_end')
          ->label(__('messages.counter_end'))
          ->sortable(),
        TextColumn::make('good_parts_count')
          ->label(__('messages.good_parts_count'))
          ->sortable(),
        TextColumn::make('technological_waste')
          ->label(__('messages.technological_waste'))
          ->sortable(),

        TextColumn::make('palet_number')
          ->label(__('messages.palet_number'))
          ->sortable(),
      ])
      ->recordActions([
        EditAction::make()
          ->modalWidth('5xl')
          ->closeModalByClickingAway(true)
          ->schema([
            Grid::make()
              ->schema([
                DatePicker::make('date')
                  ->label(__('messages.date'))
                  ->native(false)
                  ->required(),
                TimePicker::make('start_time')
                  ->label(__('messages.start_time'))
                  ->format('H:i')
                  ->withoutSeconds()
                  ->required(),
                TextInput::make('counter_start')
                  ->label(__('messages.counter_start'))
                  ->required()
                  ->numeric(),
                TimePicker::make('end_time')
                  ->label(__('messages.end_time'))
                  ->format('H:i')
                  ->withoutSeconds(),
                TextInput::make('counter_end')
                  ->label(__('messages.counter_end'))
                  ->required()
                  ->numeric(),
                TextInput::make('good_parts_count')
                  ->label(__('messages.good_parts_count'))
                  ->required()
                  ->numeric(),
                TextInput::make('technological_waste')
                  ->label(__('messages.technological_waste'))
                  ->required()
                  ->numeric(),

                TextInput::make('palet_number')
                  ->label(__('messages.palet_number')),

                Textarea::make('stopage_reason')
                  ->label(__('messages.stopage_reason'))
                  ->rows(3),
                Textarea::make('notes')
                  ->label(__('messages.notes'))
                  ->rows(3),
                Hidden::make('operation_type')
                  ->default(ProductionOperation::TYPE_MACHINE_TRIMMING),
              ])
              ->columns(2)
          ]),
        DeleteAction::make(),
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ]);
  }

  protected function getHeaderActions(): array
  {
    return [
      CreateAction::make()
        ->label(__('messages.new_input'))
        ->modalHeading(__('messages.new_input'))
        ->modalDescription(__('messages.enter_details_for_new_input'))
        ->modalWidth('5xl')
        ->closeModalByClickingAway(true)
        ->createAnother(false)
        ->schema([
          Grid::make()
            ->schema([
              Grid::make()->columnSpanFull()->schema([
                Grid::make()
                  ->schema([
                    DatePicker::make('date')
                      ->label(__('messages.date'))
                      ->native(false)
                      ->required()
                      ->default(now()->format('Y-m-d')),
                    TimePicker::make('start_time')
                      ->label(__('messages.start_time'))
                      ->format('H:i')
                      ->withoutSeconds()
                      ->default(function () {
                        $hour = now()->hour;
                        if ($hour >= 6 && $hour < 14) {
                          return '06:00';
                        } elseif ($hour >= 14 && $hour < 22) {
                          return '14:00';
                        } else {
                          return '22:00';
                        }
                      }),
                    TextInput::make('counter_start')
                      ->label(__('messages.counter_start'))
                      ->required()
                      ->numeric(),
                    TimePicker::make('end_time')
                      ->label(__('messages.end_time'))
                      ->format('H:i')
                      ->withoutSeconds()
                      ->default(function (callable $get) {
                        $startTime = $get('start_time');
                        if (empty($startTime)) {
                          return null;
                        }

                        try {
                          return Carbon::createFromFormat('H:i', $startTime)
                            ->addHours(8)
                            ->format('H:i');
                        } catch (Exception $e) {
                          return null;
                        }
                      }),
                    TextInput::make('counter_end')
                      ->label(__('messages.counter_end'))
                      ->required()
                      ->numeric(),
                    TextInput::make('good_parts_count')
                      ->label(__('messages.good_parts_count'))
                      ->required()
                      ->numeric(),
                    TextInput::make('technological_waste')
                      ->label(__('messages.technological_waste'))
                      ->required()
                      ->numeric(),

                    TextInput::make('palet_number')
                      ->label(__('messages.palet_number')),
                    Hidden::make('operation_type')
                      ->default(ProductionOperation::TYPE_MACHINE_TRIMMING),
                  ])
                  ->columns(2)
                  ->columnSpan(['lg' => 2]),

                Grid::make()
                  ->schema([
                    Textarea::make('stopage_reason')
                      ->label(__('messages.stopage_reason'))
                      ->rows(6),
                    Textarea::make('notes')
                      ->label(__('messages.notes'))
                      ->rows(6),
                  ])
                  ->columns(1)
                  ->columnSpan(['lg' => 1]),
              ])->columns(3),
            ])
        ])
        ->using(function (array $data) {
          $data['series_tender_id'] = $this->record;
          return ProductionOperation::create($data);
        }),
    ];
  }

  protected function getHeaderWidgets(): array
  {
    return [
      MachineTrimmingStatsWidget::make([
        'record' => SeriesTender::find($this->record)
      ]),
    ];
  }
}
