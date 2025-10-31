<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\HasSettingsSubNavigation;
use App\Settings\AppSettings;
use BackedEnum;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageAppSettings extends SettingsPage
{
    use HasSettingsSubNavigation;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string $settings = AppSettings::class;
    

    public static function getNavigationLabel(): string
    {
        return __('messages.settings');
    }

    protected static ?string $slug = 'manage-app-settings';
    protected static ?string $title = 'Nastavitve';

    protected static bool $shouldRegisterNavigation = true;
    protected static ?int $navigationSort = 900;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('messages.brand_information'))
                    ->schema([
                        TextInput::make('brand_name')
                            ->label(__('messages.brand_name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('company_name')
                            ->label(__('messages.company_name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('logo_url')
                            ->label(__('messages.logo_url'))
                            ->url()
                            ->maxLength(500),
                    ]),
                Section::make('Footer Settings')
                    ->description('Customize your application footer')
                    ->schema([
                        Textarea::make('footer_text')
                            ->label('Footer Text')
                            ->rows(3)
                            ->maxLength(1000),
                    ]),
            ]);
    }
}
