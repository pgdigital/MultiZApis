<?php

namespace App\Providers;

use App\Models\Module;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if(!Schema::hasTable('modules')) {
            return;
        }

        $this->checkAndRegisterModules();

        Cache::remember('modules-1', now()->minutes(1), function () {
            $modules = \App\Models\Module::where('enabled', true)->pluck('name');
      
            $modules->lazy()->each(function ($module) {
                $modulePath = base_path("modules/{$module}");
                if(!File::exists("{$modulePath}/module.json")) {
                    return;
                }

                $provider = "Modules\\{$module}\\App\\Providers\\{$module}ServiceProvider";

                if(class_exists($provider)) {
                    $this->app->register($provider);
                }
            });
        });
    }

    private function checkAndRegisterModules()
    {
        $modulePath = base_path('modules');

        if(!File::exists($modulePath)) {
            return;
        }

        $moduleDirectories = File::directories($modulePath);

        foreach($moduleDirectories as $modulePath) {
            $moduleName = basename($modulePath);

            $module = Module::query()->where('name', $moduleName)->first();

            if(!$module) {
                Module::query()->create([
                    'name' => $moduleName,
                    'enabled' => false,
                ]);
            }
        }
    }
}
