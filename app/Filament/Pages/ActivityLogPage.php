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

class ActivityLogPage extends Page implements HasTable
{
    use InteractsWithTable;
    use HasSettingsSubNavigation;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $slug = 'activity-log-page';


    protected static ?string $title = 'Dnevnik test2';

    protected static bool $shouldRegisterNavigation = false;
    
    protected string $view = 'filament.pages.activity-log-page';
    

    public function table(Table $table): Table
    {
        return $table
            ->query(ActivityLog::query()->latest())
            ->columns([
                BadgeColumn::make('log_name')
                    ->label(__('messages.log_type'))
                    ->color(fn ($state) => match ($state) {
                        'Resource' => 'gray',
                        'Access' => 'success',
                        'Notification' => 'warning',
                        'Model' => 'danger',
                        default => 'gray'
                    })

                    ->sortable(),
                TextColumn::make('description')
                    ->label(__('messages.log_description'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subject_type')
                    ->label(__('messages.log_subject_type'))
                    ->formatStateUsing(fn ($state) => class_basename($state))
                    ->sortable(),
                TextColumn::make('causer.name')
                    ->label(__('messages.log_causer'))
                    ->default('System')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('messages.date'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordUrl(fn (ActivityLog $record): string => "/admin/activity-logs/{$record->id}")
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50]);
    }

 
}