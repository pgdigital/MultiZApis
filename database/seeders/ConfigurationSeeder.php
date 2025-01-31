<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Configuration::query()->create([
            'name' => 'PanelZap',
            'logo_path' => 'images/logo.jpeg',
            'favicon_path' => 'favicon.ico',
            'home_image_path' => 'images/illustrations/dashboard-check.svg'
        ]);
    }
}
