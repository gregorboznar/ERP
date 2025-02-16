<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Facades\Schema;
use App\Filament\Pages\MaintenanceChecks;
use Illuminate\Support\HtmlString;
use Filafly\PhosphorIconReplacement;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $brandName = 'Admin';
        try {
            if (class_exists(\App\Models\Settings::class) && \Schema::hasTable('settings')) {
                $settings = \App\Models\Settings::first();
                $brandName = $settings ? $settings->title : 'Admin';
            }
        } catch (\Exception $e) {
            // Silently continue with default brand name if there's an error
        }

        return $panel
            ->spa()
            ->sidebarCollapsibleOnDesktop()
            ->default()
            ->id('admin')
            ->brandName($brandName)
            ->path('admin')
            ->login()
            ->viteTheme('resources/css/filament/admin/theme.css')

            ->colors([
                'primary' => Color::Amber,
            ])
            ->plugin(PhosphorIconReplacement::make())
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
                MaintenanceChecks::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
