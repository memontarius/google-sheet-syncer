<?php

namespace App\Providers;

use App\Services\EntryService;
use App\Services\SheetsSettingsService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $singletons = [
        SheetsSettingsService::class => SheetsSettingsService::class,
        EntryService::class => EntryService::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
