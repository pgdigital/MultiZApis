<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;
use Symfony\Component\VarDumper\Cloner\Stub;

class ModuleModelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:model {module} {name} {--m}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $module = Str::studly($this->argument('module'));
        $name = Str::studly($this->argument('name'));

        $modulePath = "modules/{$module}";

        if (!File::exists($modulePath)) {
            $this->error("O módulo '{$module}' não existe.");
            return;
        }

        $modelsPath = base_path("{$modulePath}/app/Models");

        if (!File::exists($modelsPath)) {
            $this->error("O diretório 'app/Models' não existe no módulo '{$module}'.");
            return;
        }

        $this->createFile('model.stub', "{$modelsPath}/{$name}.php", [
            'moduleName' => $module,
            'className' => $name,
            'tableName' => Str::snake($module.Str::plural($name)),
        ]);


        $this->info("Model '{$name}' criado com sucesso no módulo '{$module}'.");

        if ($this->option('m')) {
            $migrationName = Str::plural($name);
            $migrationName = Str::snake($module).$migrationName;
            $this->call('module:migration', [
                'module' => $module,
                'name' => "create_{$migrationName}Table",
            ]);
        }
    }

    private function createFile($stub, $path, $replacements)
    {
        $stubContent = File::get(resource_path("stubs/{$stub}"));
        foreach ($replacements as $key => $value) {
            $stubContent = str_replace("{{{$key}}}", $value, $stubContent);
        }
        File::put($path, $stubContent);
    }
}
