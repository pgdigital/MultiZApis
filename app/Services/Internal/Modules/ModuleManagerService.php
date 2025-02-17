<?php

namespace App\Services\Internal\Modules;

use App\Models\Module;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;

class ModuleManagerService {

    public function all()
    {
        return Module::all()->map(function($module) {
            return array_merge([
                'enabled' => (bool) $module->enabled,
            ], $this->getModuleInfo($module->name));
        });
    }

    public function get($name)
    {
        $module = Module::where('name', $name)->first();

        if(!$module) {
            return null;
        }

        return (object) array_merge([
            'enabled' => (bool) $module->enabled,
        ], $this->getModuleInfo($module->name));
    }

    public function enable($name)
    {
        $module = Module::where('name', $name)->first();

        if(!$module) {
            return null;
        }

        $module->update([
            'enabled' => true,
        ]);

        Process::path(base_path())->run('php artisan config:clear');

        return $module;
    }

    public function disable($name)
    {
        $module = Module::where('name', $name)->first();

        if(!$module) {
            return null;
        }

        $module->update([
            'enabled' => false,
        ]);

        Process::path(base_path())->run('php artisan config:clear');

        return $module;
    }

    public function getModuleInfo($name)
    {
        $modulePath = base_path("modules/{$name}");

        if(!file_exists("{$modulePath}/module.json")) {
            return null;
        }

        return json_decode(file_get_contents("{$modulePath}/module.json"));   
    }
}