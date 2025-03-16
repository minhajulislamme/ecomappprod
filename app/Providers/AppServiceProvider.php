<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Admin\SettingsController;

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
        // Share tracking IDs with all views
        View::composer('*', function ($view) {
            $view->with([
                'gtm_id' => SettingsController::getGTMId(),
                'pixel_id' => SettingsController::getPixelId(),
            ]);
        });
    }
}
