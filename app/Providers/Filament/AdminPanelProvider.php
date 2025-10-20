<?php

namespace App\Providers\Filament;

use App\Settings\AppSettings;
use Exception;
use Filament\Pages\Dashboard;
use Filament\Widgets\AccountWidget;
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
use App\Filament\Pages\MaintenanceChecks;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Jacobtims\FilamentLogger\FilamentLoggerPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $brandName = 'Admin';
        try {
            $settings = app(AppSettings::class);
            $brandName = $settings->brand_name ?? $brandName;
        } catch (Exception $e) {
        }

        return $panel
            ->spa()
            ->sidebarCollapsibleOnDesktop()
            ->default()
            ->id('admin')
            ->brandName($brandName)
            ->brandLogo(asset('images/logo.png'))
            ->darkModeBrandLogo(asset('images/logo.png'))
            ->brandlogoHeight('3rem')
            ->favicon(asset('favicon.png'))
            ->path('admin')
            ->login()
            ->viteTheme([
                'resources/css/filament/admin/theme.css',
                'resources/js/filament/admin/theme.js',
            ])
            ->databaseNotifications()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
                MaintenanceChecks::class,
            ])
            ->widgets([
                AccountWidget::class,
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
            ])
            ->plugin(FilamentShieldPlugin::make())
            ->plugin(FilamentLoggerPlugin::make());
    }
}
