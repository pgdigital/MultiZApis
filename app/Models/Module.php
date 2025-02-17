<?php

namespace App\Models;

use App\Facades\Module as FacadesModule;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;

class Module extends Model
{
    protected $fillable = [
        'name',
        'enabled',
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    protected $appends = [
        'slug',
        'informations',
    ];

    public function informations(): Attribute
    {
        return new Attribute(
            get: function() {
                return FacadesModule::getModuleInfo($this->name);
            }
        );    
    }
    
    public function slug(): Attribute
    {
        return new Attribute(
            get: function() {
                return Str::slug($this->name);
            }
        );
    }

    public function enable()
    {
        $module = Str::studly($this->name);
        $modulePath = "modules/{$module}";

        if(!File::exists(base_path($modulePath))) {
            throw new \Exception("Módulo {$module} não encontrado.");
        }

        Process::path(base_path())->run("php artisan migrate --path={$modulePath}/Database/migrations --force");

        FacadesModule::enable($this->name);
    }

    public function disable()
    {
        $module = Str::studly($this->name);
        $modulePath = "modules/{$module}";

        if(!File::exists(base_path($modulePath))) {
            throw new \Exception("Módulo {$module} não encontrado.");
        }

        if(DB::connection()->getName() == 'pgsql') {
            $tables = DB::select('SELECT * FROM pg_catalog.pg_tables;');
        } else if(DB::connection()->getName() == 'mysql') {
            $tables = DB::select('SHOW TABLES');
        }

        foreach($tables as $table) {
            $table = reset($table);

            if(Str::startsWith($table, $module)) {
                DB::statement("DROP TABLE IF EXISTS {$table}");
            }
        }

        FacadesModule::disable($this->name);
    }
}
