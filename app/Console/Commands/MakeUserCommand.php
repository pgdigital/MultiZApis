<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

use function Laravel\Prompts\form;

class MakeUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'makeUser';

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
        $response = form()
            ->text('Nome do seu usuário', required: true, name: 'name')
            ->text('E-mail do seu usuário', required: true, name: 'email', validate: ['email' => 'email'])
            ->password('Senha do seu usuário', required: true, name: 'password', validate: ['password' => 'min:8'])
            ->submit();

        User::query()->create($response);

        info('Seu usuário foi criado com sucesso!');
    }
}
