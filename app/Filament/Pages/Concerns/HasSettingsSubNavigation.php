<?php

namespace App\Filament\Pages\Concerns;

use Filament\Navigation\NavigationItem;

trait HasSettingsSubNavigation
{
    public function getSubNavigation(): array
    {
        return [
            NavigationItem::make('settings')
                ->label(__('messages.settings'))
                ->icon('heroicon-o-cog-6-tooth')
                ->url(fn () => '/admin/manage-app-settings')
                ->isActiveWhen(fn () => str_contains(request()->url(), 'manage-app-settings')),

            NavigationItem::make('activity-log')
                ->label(__('messages.activity_log'))
                ->icon('heroicon-o-clipboard-document-list')
                ->url(fn () => '/admin/activity-log-page')
                ->isActiveWhen(fn () => str_contains(request()->url(), 'activity-log-page')),

             NavigationItem::make('shield-roles')
                ->label(__('messages.shield_roles'))
                ->icon('heroicon-o-shield-check')
                ->url(fn () => '/admin/shield-page')
                ->isActiveWhen(fn () => str_contains(request()->url(), 'shield-page')),
        ];
    }
}


