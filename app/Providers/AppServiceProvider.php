<?php

namespace App\Providers;

use App\Interfaces\WhatsappServiceInterface;
use App\Services\EvolutionService;
use App\Services\Internal\Modules\ModuleManagerService;
use Illuminate\Support\Facades\Gate;
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

        $this->app->singleton('module', function() {
            return new ModuleManagerService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if(app()->isProduction()) {
            URL::forceScheme('https');
        }

        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Administrador') ? true : null;
        });
    }
}
