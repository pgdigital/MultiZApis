<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;

class ModuleMigrationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:migration {module} {name}';

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
        $name = Str::snake($this->argument('name'));

        $modulePath = "modules/{$module}";

        if (!File::exists($modulePath)) {
            $this->error("O módulo '{$module}' não existe.");
            return;
        }

        $migrationsPath = "{$modulePath}/database/migrations";

        if(!File::exists($migrationsPath)) {
            $this->error("O diretório de migrations '{$migrationsPath}' não existe.");
            return;
        }

        $response = Process::path(base_path())->run("php artisan make:migration {$name} --path={$migrationsPath}");

        if(!$response->successful()) {
            $this->error("Erro ao criar a migration.");
            return;
        }

        return $this->info($response->output());
    }
}
