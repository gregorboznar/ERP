<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\HasSettingsSubNavigation;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Spatie\Activitylog\Models\Activity as ActivityLog;
use Filament\Tables\Columns\BadgeColumn;
use UnitEnum;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Filament\Tables\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;

class ShieldPage extends Page implements HasTable
{
    use InteractsWithTable;
    use HasSettingsSubNavigation;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static ?string $slug = 'shield-page';


    protected static ?string $title = 'Vloge in dovoljenja';

    protected static bool $shouldRegisterNavigation = false;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
    
    protected string $view = 'filament.pages.shield-page';
    

    public function table(Table $table): Table
    {
        return $table
            ->query(Role::query()->with('permissions')->latest())
            ->columns([
                TextColumn::make('name')
                    ->label(__('messages.name'))
                    ->sortable(),
                BadgeColumn::make('guard_name')
                    ->label(__('messages.guard_name'))
                    ->color(fn ($state) => match ($state) {
                        'web' => 'success',
                        'api' => 'warning',
                        default => 'gray'
                    })
                    ->sortable(),
                TextColumn::make('permissions_count')
                    ->label(__('messages.permissions'))
                    ->counts('permissions')
                    ->sortable()
                    ->badge(),
                TextColumn::make('updated_at')
                    ->label(__('messages.updated_at'))
                    ->dateTime()
                    ->sortable(),
                    
            ])
                ->recordActions([
                EditAction::make()
                    ->label(__('messages.edit'))
                    ->url(fn (Role $record): string => "/admin/shield/roles/{$record->id} /edit"),
                DeleteAction::make()
                    ->label(__('messages.delete'))
                    ->modalHeading(__('messages.delete_role'))
                    ->modalDescription(__('messages.delete_role_confirmation'))
                    ->modalSubmitActionLabel(__('messages.confirm_delete'))
                    ->modalCancelActionLabel(__('messages.cancel'))
                    ->successNotification(fn () => Notification::make()
                        ->title(__('messages.deleted'))
                        ->success()
                        ->send()),
            ])
            ->recordUrl(fn (Role $record): string => "/admin/shield/roles/{$record->id}/edit")
            ->defaultSort('name', 'asc')
            ->paginated([10, 25, 50]);
    }

 
}