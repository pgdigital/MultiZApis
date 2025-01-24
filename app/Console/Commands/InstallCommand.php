<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Process;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install {--docker}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to install the application';
    
    /**
     * Execute the console command.
     */
    public function handle()
    {
        if(!$this->option('docker')) {
            $this->copyEnvFile();

            $appHost = text(label: 'Qual o domínio da sua aplicação ?', required: true);

            $this->setEnvVariable("APP_URL",  $appHost);

            $dbHost = text(
                label: "Qual o host do banco de dados ?",
                default: "localhost"
            );

            $this->setEnvVariable("DB_HOST",  $dbHost);

            $dbPort = text(
                label: "Qual a porta do banco de dados ?",
                default: "3306"
            );

            $this->setEnvVariable("DB_PORT",  $dbPort);

            $dbUser = text(
                label: "Qual o usuário do banco de dados ?",
                default: "root"
            );

            $this->setEnvVariable("DB_USERNAME",  $dbUser);

            $dbPassword = password(
                label: "Qual a senha do banco de dados ?",
            );

            $this->setEnvVariable("DB_PASSWORD",  $dbPassword);

            $dbDatabase = text(
                label: "Qual o nome do banco de dados ?",
                default: "panel_zap"
            );

            $this->setEnvVariable("DB_DATABASE",  $dbDatabase);

            info('Banco de dados configurado com sucesso!');
        }

        Config::set('database.default', 'mysql');
        DB::purge('mysql');
        DB::reconnect('mysql');

        Process::path(base_path())->run('php artisan migrate --force');

        if(!$this->option('docker')) {
            Process::path(base_path())->run('php artisan key:generate');
        }

        Process::path(base_path())->run('php artisan db:seed --class=PermissionSeeder --force');
        Process::path(base_path())->run('php artisan db:seed --class=RoleSeeder --force');
        Process::path(base_path())->run('php artisan db:seed --class=WhatsappIntegrationSeeder --force');

        if(!$this->option('docker')) {
            $this->setEnvVariable("APP_ENV",  "production");

            $this->setEnvVariable("APP_DEBUG",  "false");

            $this->setEnvVariable("APP_TIMEZONE",  "America/Sao_Paulo");

            $this->setEnvVariable("APP_LOCALE",  "pt_BR");
        }

    }

    public function setEnvVariable($key, $value)
    {
        if (!file_exists(base_path('.env'))) {
            throw new \Exception("O arquivo .env não foi encontrado no caminho especificado.");
        }
    
        $envContent = file_get_contents(base_path('.env'));
    
        
        $keyExists = preg_match("/^$key=.*$/m", $envContent);
    
        if ($keyExists) {
            $envContent = preg_replace(
                "/^$key=.*$/m",
                "$key=$value",
                $envContent
            );
        } else {
            $envContent .= PHP_EOL . "$key=$value";
        }

        file_put_contents(base_path('.env'), $envContent);

        return;
    }

    public function copyEnvFile()
    {
        $source = base_path('.env.example'); 
        $destination = base_path('.env');  
    
        if (!file_exists($source)) {
            throw new \Exception("O arquivo .env.example não foi encontrado.");
        }
    
        if (file_exists($destination)) {
            throw new \Exception("O arquivo .env já existe. Não é possível sobrescrevê-lo.");
        }
    
        if (copy($source, $destination)) {
            return;
        } else {
            throw new \Exception("Erro ao copiar o arquivo .env.example para .env.");
        }
    }
}
