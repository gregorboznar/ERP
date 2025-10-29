<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Navigation\NavigationItem;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Spatie\Activitylog\Models\Activity as ActivityLog;
use Filament\Tables\Columns\BadgeColumn;
use UnitEnum;
use BackedEnum;

class ActivityLogPage extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $slug = 'activity-log-page';
    
    protected static ?string $title = 'Activity Log';

    protected static bool $shouldRegisterNavigation = false;
    
    protected string $view = 'filament.pages.activity-log-page';
    

    public function table(Table $table): Table
    {
        return $table
            ->query(ActivityLog::query()->latest())
            ->columns([
                BadgeColumn::make('log_name')
                    ->label('Log Nameeee')
                    ->color(fn ($state) => match ($state) {
                        'Resource' => 'gray',
                        'Access' => 'success',
                        'Notification' => 'warning',
                        'Model' => 'danger',
                        default => 'gray'
                    })

                    ->sortable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subject_type')
                    ->label('Subject Type')
                    ->formatStateUsing(fn ($state) => class_basename($state))
                    ->sortable(),
                TextColumn::make('causer.name')
                    ->label('User')
                    ->default('System')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordUrl(fn (ActivityLog $record): string => "/admin/activity-logs/{$record->id}")
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50]);
    }

    public function getSubNavigation(): array
    {
        return [
            NavigationItem::make('settings')
                ->label('Settings')
                ->icon('heroicon-o-cog-6-tooth')
                ->url(fn () => '/admin/manage-app-settings')
                ->isActiveWhen(fn() => str_contains(request()->url(), 'manage-app-settings')),

            NavigationItem::make('activity-log')
                ->label('Activity Log')
                ->icon('heroicon-o-clipboard-document-list')
                ->url(fn () => '/admin/activity-log-page')
                ->isActiveWhen(fn() => str_contains(request()->url(), 'activity-log-page')),
        ];
    }
}