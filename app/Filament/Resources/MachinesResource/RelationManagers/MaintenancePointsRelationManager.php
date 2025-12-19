<?php

namespace App\Filament\Resources\MachinesResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\AttachAction;
use Filament\Actions\EditAction;
use Filament\Actions\DetachAction;
use Filament\Actions\BulkActionGroup;
use App\Models\MaintenancePoint;
use Filament\Forms;
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

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label(__('messages.name')),

                Textarea::make('description')
                    ->maxLength(1000)
                    ->label(__('messages.description'))
                    ->columnSpanFull(),

                TextInput::make('location')
                    ->label(__('messages.location')),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->defaultSort('name')
            ->columns([
                TextColumn::make('name')
                    ->label(__('messages.name'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('description')
                    ->label(__('messages.description'))
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),

                TextColumn::make('location')
                    ->label(__('messages.location'))
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('messages.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('messages.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label(__('messages.new_maintenance_point')),
                AttachAction::make()
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
            ->recordActions([
                EditAction::make(),
                DetachAction::make(),
               /*  Tables\Actions\DeleteAction::make(), */
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                /*     Tables\Actions\DetachBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(), */
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }
}
