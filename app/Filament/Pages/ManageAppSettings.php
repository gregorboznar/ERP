<?php

namespace App\Filament\Pages;

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
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string $settings = AppSettings::class;

    protected static ?string $navigationLabel = 'App Settings';

    protected static ?string $title = 'Application Settings';

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

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
}
