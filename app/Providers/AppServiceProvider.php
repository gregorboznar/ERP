<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;
use App\Livewire\ConfirmationComplianceForm;
use App\Policies\ActivityPolicy;
use Spatie\Activitylog\Models\Activity;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Livewire::component('confirmation-compliance-form', ConfirmationComplianceForm::class);

        // Register Activity Policy
        Gate::policy(Activity::class, ActivityPolicy::class);
    }
}
