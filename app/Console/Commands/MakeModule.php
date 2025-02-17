<?php

namespace App\Console\Commands;

use App\Models\Module;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModule extends Command
{
    protected $signature = 'make:module {name} {--author=Unknown} {--description=No description}';
    protected $description = 'Cria um novo módulo completo';

    public function handle()
    {
        $name = $this->argument('name');
        $lowername = str()->slug($name, '-');
        $author = $this->option('author');
        $description = $this->option('description');

        // Module::create([
        //     'name' => $name,
        //     'enabled' => false
        // ]);

        $modulePath = base_path("modules/{$name}");

        if (File::exists($modulePath)) {
            $this->error("O módulo '{$name}' já existe!");
            return;
        }

        $folders = [
            'App/Http/Controllers',
            'App/Models',
            'App/Providers',
            'Config', 
            'Database/migrations', 
            'Database/Factories',
            'Database/Seeders',
            'resources/views', 
            'routes'
        ];

        foreach ($folders as $folder) {
            File::makeDirectory("{$modulePath}/{$folder}", 0755, true);
        }

        $this->createFile('module.stub', "{$modulePath}/module.json", compact('name', 'author', 'description'));
        $this->createFile('module_provider.stub', "{$modulePath}/App/Providers/{$name}ServiceProvider.php", compact('name', 'lowername'));
        $this->createFile('controller.stub', "{$modulePath}/App/Http/Controllers/{$name}Controller.php", compact('name', 'lowername'));
        $this->createFile('routes.stub', "{$modulePath}/routes/web.php", compact('name', 'lowername'));
        $this->createFile('config.stub', "{$modulePath}/config/config.php", compact('name'));
        $this->createFile('seeder.stub', "{$modulePath}/Database/seeders/{$name}Seeder.php", compact('name'));
        $this->createFile('view.stub', "{$modulePath}/resources/views/index.blade.php", compact('name'));

        $this->info("Módulo '{$name}' criado com sucesso!");
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
