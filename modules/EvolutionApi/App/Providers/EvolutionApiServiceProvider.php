<?php

namespace Modules\EvolutionApi\App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\EvolutionApi\App\Services\WhatsappProvider;
use App\Services\Internal\Whatsapp\WhatsappManagerService;

class EvolutionApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'evolutionapi');
        $this->registerRoutes();
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'evolutionapi');
        $this->loadMigrationsFrom(__DIR__ . '/../../Database/migrations');
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('evolutionapi.php'),
        ], 'config');

        $this->app->resolving(WhatsappManagerService::class, function($manager) {
            $manager->registerModule(WhatsappProvider::class);
        });
    }

    protected function registerRoutes()
    {
        Route::middleware('web')
            ->prefix('integracoes')
            ->as("integrations.")
            ->group(fn() => require __DIR__ . '/../../routes/web.php');
    }

    private function getModuleName()
    {
        $namespaceParts = explode('\\', __NAMESPACE__);
        return strtolower($namespaceParts[1]);
    }
}
