<?php

namespace App\Filament\Resources\MachinesResource\RelationManagers;

use App\Models\MaintenancePoint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class MaintenancePointsRelationManager extends RelationManager
{
    protected static string $relationship = 'maintenancePoints';

    protected static ?string $title = null;
    
    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('messages.daily_maintenance_activity');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label(__('messages.name')),

                Forms\Components\Textarea::make('description')
                    ->maxLength(1000)
                    ->label(__('messages.description'))
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('location')
                    ->required()
                    ->label(__('messages.location')),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->defaultSort('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('messages.name'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->label(__('messages.description'))
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),

                Tables\Columns\TextColumn::make('location')
                    ->label(__('messages.location'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('messages.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('messages.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label(__('messages.new_maintenance_point')),
                Tables\Actions\AttachAction::make()
                    ->recordSelectOptionsQuery(function (Builder $query) {
                        $machineId = $this->getOwnerRecord()->getKey();
                        return $query->whereNotExists(function ($subQuery) use ($machineId) {
                            $subQuery->select(\DB::raw(1))
                                ->from('machine_maintenance_point')
                                ->whereRaw('machine_maintenance_point.maintenance_point_id = maintenance_points.id')
                                ->where('machine_maintenance_point.machine_id', $machineId);
                        })->orderBy('name');
                    })
                    ->recordTitleAttribute('name')
                    ->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
               /*  Tables\Actions\DeleteAction::make(), */
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                /*     Tables\Actions\DetachBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(), */
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }
}
