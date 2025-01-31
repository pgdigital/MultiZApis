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
            if(Schema::hasTable('configurations')) {
                $configuration = Configuration::first();
    
                if($configuration) 
                {
                    View::share('title', $configuration->name);

                    if(Storage::exists($configuration->logo_path)) {
                        View::share('logo', url('file/'.$configuration->logo_path));
                    } else {
                        View::share('logo', asset($configuration->logo_path));
                    }

                    if(Storage::exists($configuration->favicon_path)) {
                        View::share('favicon', url('file/'.$configuration->favicon_path));
                    } else {
                        View::share('favicon', asset($configuration->favicon_path));
                    }

                    if(Storage::exists($configuration->home_image_path)) {
                        View::share('home_bg', url('file/'.$configuration->home_image_path));
                    } else {
                        View::share('home_bg', asset($configuration->home_image_path));
                    }
                }
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
