<?php

namespace App\Providers;

use App\Models\Configuration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', 'App\Http\View\Composers\SidebarComposer');
        try {
            if(Schema::connection_status()) {
                $configuration = Configuration::first();
    
                if($configuration) 
                {
                    View::share('title', $configuration->name);
                    if(config('filesystems.default') == 's3') {
                        View::share('logo', Storage::link($configuration->logo_path));
                        View::share('favicon', Storage::link($configuration->favicon_path));
                        View::share('home_bg', Storage::link($configuration->home_image_path));
                        
                    } else {
                        View::share('logo', asset($configuration->logo_path));
                        View::share('favicon', asset($configuration->favicon_path));
                        View::share('home_bg', asset($configuration->home_image_path));
                    }
                }
            }
        } catch (\Exception $e) {
            // Do nothing
        }
    }
}
