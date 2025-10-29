<?php

namespace App\Filament\Pages;

use App\Settings\AppSettings;
use BackedEnum;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Navigation\NavigationItem;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageAppSettings extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string $settings = AppSettings::class;

    
    protected static ?string $title = 'Settings';

    protected static ?string $slug = 'manage-app-settings';



    protected static bool $shouldRegisterNavigation = true;
    protected static ?int $navigationSort = 900;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Brand Information')
                    ->description('Manage your application branding and company details')
                    ->schema([
                        TextInput::make('brand_name')
                            ->label('Brand Name')
                            ->helperText('This will be displayed in the admin panel header')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('company_name')
                            ->label('Company Name')
                            ->helperText('Your official company name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('logo_url')
                            ->label('Logo URL')
                            ->helperText('URL or path to your company logo')
                            ->url()
                            ->maxLength(500),
                    ]),
                Section::make('Footer Settings')
                    ->description('Customize your application footer')
                    ->schema([
                        Textarea::make('footer_text')
                            ->label('Footer Text')
                            ->helperText('Copyright notice or additional footer information')
                            ->rows(3)
                            ->maxLength(1000),
                    ]),
            ]);
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
