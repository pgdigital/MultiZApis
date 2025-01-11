<?php

namespace App\Providers;

use App\Interfaces\WhatsappServiceInterface;
use App\Services\EvolutionService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(WhatsappServiceInterface::class, EvolutionService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if(app()->isProduction()) {
            URL::forceScheme('https');
        }
    }
}
