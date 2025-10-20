<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class AppSettings extends Settings
{
    public string $brand_name;
    
    public string $company_name;
    
    public ?string $logo_url;
    
    public ?string $footer_text;
    
    public static function group(): string
    {
        return 'app';
    }
}

