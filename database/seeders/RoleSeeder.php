<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'Super Administrador',
        ]);

        $client = Role::create([
            'name' => 'Cliente'
        ]);

        $client->syncPermissions([
            'view_instances',
            'create_instances',
            'recreate_instances',
            'update_instances',
            'delete_instances'
        ]);
    }
}
