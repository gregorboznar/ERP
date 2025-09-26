<?php

namespace App\Filament\Resources\QualityControlResource\Pages;

use App\Filament\Resources\QualityControlResource;
use App\Models\MeasurementCharacteristic;
use App\Models\VisualCharacteristic;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListQualityControls extends ListRecords
{
    protected static string $resource = QualityControlResource::class;

    public function getTabs(): array
    {
        return [
            'measurement' => Tab::make(__('messages.measurement_characteristics'))
                ->icon('heroicon-m-calculator')
                ->badge(MeasurementCharacteristic::count()),
            'visual' => Tab::make(__('messages.visual_characteristics'))
                ->icon('heroicon-m-eye')
                ->badge(VisualCharacteristic::count()),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns($this->getTableColumns())
            ->filters([])
            ->actions($this->getTableActions())
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                /*     Tables\Actions\DeleteBulkAction::make(), */
                ]),
            ]);
    }

    protected function getTableQuery(): Builder
    {
        $activeTab = $this->activeTab ?? 'measurement';
        
        return match($activeTab) {
            'visual' => VisualCharacteristic::query(),
            default => MeasurementCharacteristic::query(),
        };
    }

    protected function getTableColumns(): array
    {
        $activeTab = $this->activeTab ?? 'measurement';
        
        if ($activeTab === 'visual') {
            return [
                Tables\Columns\TextColumn::make('name')
                    ->label(__('messages.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('messages.created_at'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('messages.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ];
        }

        return [
            Tables\Columns\TextColumn::make('name')
                ->label(__('messages.name'))
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('unit')
                ->label(__('messages.unit'))
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('nominal_value')
                ->label(__('messages.nominal_value'))
                ->sortable(),
            Tables\Columns\TextColumn::make('tolerance')
                ->label(__('messages.tolerance'))
                ->sortable(),
            Tables\Columns\TextColumn::make('updated_at')
                ->label(__('messages.updated_at'))
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    protected function getTableActions(): array
    {
        $activeTab = $this->activeTab ?? 'measurement';
        
        if ($activeTab === 'visual') {
            return [
                Tables\Actions\EditAction::make()
                    ->modalHeading(__('messages.edit_visual_characteristic'))
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->label(__('messages.name'))
                            ->required()
                            ->maxLength(255),
                    ]),
                Tables\Actions\DeleteAction::make(),
            ];
        }

        return [
            Tables\Actions\EditAction::make()
                ->modalHeading(__('messages.edit_measurement_characteristic'))
                ->form([
                    Forms\Components\TextInput::make('name')
                        ->label(__('messages.name'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('unit')
                        ->label(__('messages.unit'))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('nominal_value')
                        ->label(__('messages.nominal_value')),
                    Forms\Components\TextInput::make('tolerance')
                        ->label(__('messages.tolerance')),
                ]),
            Tables\Actions\DeleteAction::make(),
        ];
    }

    protected function getHeaderActions(): array
    {
        $activeTab = $this->activeTab ?? 'measurement';
        
        if ($activeTab === 'visual') {
            return [
                Actions\CreateAction::make()
                    ->label(__('messages.create_visual_characteristic'))
                    ->icon('heroicon-m-plus')
                    ->modalWidth('xl')
                    ->createAnother(false)
                    ->modalSubmitActionLabel(__('messages.save'))
                    ->modalCancelActionLabel(__('messages.cancel'))
                    ->model(VisualCharacteristic::class)
                    ->modalHeading(__('messages.create_visual_characteristic'))
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->label(__('messages.name'))
                            ->required()
                            ->maxLength(255),
                    ])
                    ->mutateFormDataUsing(function (array $data): array {
                        return $data;
                    }),
            ];
        }

        return [
            Actions\CreateAction::make()
                ->label(__('messages.create_measurement_characteristic'))
                ->icon('heroicon-m-plus')
                ->modalWidth('xl')
                ->createAnother(false)
                ->modalSubmitActionLabel(__('messages.save'))
                ->modalCancelActionLabel(__('messages.cancel'))
                ->model(MeasurementCharacteristic::class)
                ->modalHeading(__('messages.create_measurement_characteristic'))
                ->form([
                    Forms\Components\TextInput::make('name')
                        ->label(__('messages.name'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('unit')
                        ->label(__('messages.unit'))
                        ->maxLength(255),
                    Forms\Components\TextInput::make('nominal_value')
                        ->label(__('messages.nominal_value')),
                    Forms\Components\TextInput::make('tolerance')
                        ->label(__('messages.tolerance')),
                ])
                ->mutateFormDataUsing(function (array $data): array {
                    return $data;
                }),
        ];
    }
}
