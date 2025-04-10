<?php

namespace App\Filament\Resources\SeriesTenderResource\Pages;

use App\Filament\Resources\SeriesTenderResource;
use Filament\Resources\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
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
use App\Filament\Widgets\PackagingStatsWidget;

class PackagingsPage extends Page implements HasTable, HasForms
{
  use InteractsWithTable;
  use InteractsWithForms;
  use InteractsWithFormActions;

  protected static string $resource = SeriesTenderResource::class;

  protected static string $view = 'filament.resources.series-tender-resource.pages.packaging';

  public ?string $record = null;

  public function getTitle(): string
  {
    return __('messages.series_packaging') . ' ' . SeriesTender::find($this->record)->series_number;
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
          ->where('operation_type', ProductionOperation::TYPE_PACKAGING)
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
        TextColumn::make('batch_of_material')
          ->label(__('messages.batch_of_material'))
          ->sortable(),
        TextColumn::make('palet_number')
          ->label(__('messages.palet_number'))
          ->sortable(),

      ])
      ->actions([
        EditAction::make()
          ->modalWidth('5xl')
          ->closeModalByClickingAway(true)
          ->form([
            Forms\Components\Grid::make()
              ->schema([
                Forms\Components\DatePicker::make('date')
                  ->label(__('messages.date'))
                  ->native(false)
                  ->required(),
                Forms\Components\TimePicker::make('start_time')
                  ->label(__('messages.start_time'))
                  ->format('H:i')
                  ->withoutSeconds()
                  ->required(),
                Forms\Components\TextInput::make('counter_start')
                  ->label(__('messages.counter_start'))
                  ->required()
                  ->numeric(),
                Forms\Components\TimePicker::make('end_time')
                  ->label(__('messages.end_time'))
                  ->format('H:i')
                  ->withoutSeconds(),
                Forms\Components\TextInput::make('counter_end')
                  ->label(__('messages.counter_end'))
                  ->required()
                  ->numeric(),
                Forms\Components\TextInput::make('good_parts_count')
                  ->label(__('messages.good_parts_count'))
                  ->required()
                  ->numeric(),
                Forms\Components\TextInput::make('technological_waste')
                  ->label(__('messages.technological_waste'))
                  ->required()
                  ->numeric(),
                Forms\Components\TextInput::make('batch_of_material')
                  ->label(__('messages.batch_of_material')),
                Forms\Components\TextInput::make('palet_number')
                  ->label(__('messages.palet_number')),
                Forms\Components\TextInput::make('batch_of_material')
                  ->label(__('messages.batch_of_material'))
                  ->numeric(),
                Forms\Components\Textarea::make('stopage_reason')
                  ->label(__('messages.stopage_reason'))
                  ->rows(3),
                Forms\Components\Textarea::make('notes')
                  ->label(__('messages.notes'))
                  ->rows(3),
                Forms\Components\Hidden::make('operation_type')
                  ->default(ProductionOperation::TYPE_PACKAGING),
              ])
              ->columns(2)
          ]),
        DeleteAction::make(),
      ])
      ->bulkActions([
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
        ->form([
          Forms\Components\Grid::make()
            ->schema([
              Forms\Components\Grid::make()->schema([

                Forms\Components\Grid::make()
                  ->schema([
                    Forms\Components\DatePicker::make('date')
                      ->label(__('messages.date'))
                      ->native(false)
                      ->required()
                      ->default(now()->format('Y-m-d')),
                    Forms\Components\TimePicker::make('start_time')
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
                    Forms\Components\TextInput::make('counter_start')
                      ->label(__('messages.counter_start'))
                      ->required()
                      ->numeric(),
                    Forms\Components\TimePicker::make('end_time')
                      ->label(__('messages.end_time'))
                      ->format('H:i')
                      ->withoutSeconds()
                      ->default(function (callable $get) {
                        $startTime = $get('start_time');
                        if (empty($startTime)) {
                          return null;
                        }

                        try {
                          return \Carbon\Carbon::createFromFormat('H:i', $startTime)
                            ->addHours(8)
                            ->format('H:i');
                        } catch (\Exception $e) {
                          return null;
                        }
                      }),
                    Forms\Components\TextInput::make('counter_end')
                      ->label(__('messages.counter_end'))
                      ->required()
                      ->numeric(),
                    Forms\Components\TextInput::make('good_parts_count')
                      ->label(__('messages.good_parts_count'))
                      ->required()
                      ->numeric(),
                    Forms\Components\TextInput::make('technological_waste')
                      ->label(__('messages.technological_waste'))
                      ->required()
                      ->numeric(),
                    Forms\Components\TextInput::make('batch_of_material')
                      ->label(__('messages.batch_of_material'))
                      ->numeric(),
                    Forms\Components\TextInput::make('palet_number')
                      ->label(__('messages.palet_number')),
                    Forms\Components\Hidden::make('operation_type')
                      ->default(ProductionOperation::TYPE_PACKAGING),
                  ])
                  ->columns(2)
                  ->columnSpan(['lg' => 2]),


                Forms\Components\Grid::make()
                  ->schema([
                    Forms\Components\Textarea::make('stopage_reason')
                      ->label(__('messages.stopage_reason'))
                      ->rows(6),
                    Forms\Components\Textarea::make('notes')
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
      PackagingStatsWidget::make([
        'record' => SeriesTender::find($this->record)
      ]),
    ];
  }
}
