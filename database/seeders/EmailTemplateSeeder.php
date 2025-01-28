<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmailTemplate::query()->firstOrCreate([
            'type' => 'reset-password',
            'subject' => 'Recuperação de senha',
            'content' => 'Olá, você solicitou a recuperação de senha. Clique no link abaixo para redefinir sua senha: {{ button }}',
            'is_active' => true,
        ]);
    }
}
