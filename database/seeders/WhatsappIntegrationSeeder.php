<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WhatsappIntegration;

class WhatsappIntegrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WhatsappIntegration::create([
            "base_url" => "https://subdominio.seudominio.com.br",
            "token" => "token global"
        ]);
    }
}
