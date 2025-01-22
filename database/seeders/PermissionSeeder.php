<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
               'name' => 'view_clients',
               'label' => 'Ver clientes'
            ],
            [
                'name' => 'create_clients',
                'label' => 'Cadastrar cliente'
            ],
            [
                'name' => 'update_clients',
                'label' => 'Editar cliente'
            ],
            [
                'name' => 'delete_clients',
                'label' => 'Excluir cliente'
            ],
            [
                'name' => 'view_instances',
                'label' => 'Ver instâncias'
            ],
            [
                'name' => 'create_instances',
                'label' => 'Cadastrar instância'
            ],
            [
                'name' => 'recreate_instances',
                'label' => 'Recriar instância'
            ],
            [
                'name' => 'update_instances',
                'label' => 'Editar instância'
            ],
            [
                'name' => 'delete_instances',
                'label' => 'Excluir instância'
            ],
            [
                'name' => 'configuration_apis',
                'label' => 'Configuração de APIs'
            ]
        ];

        foreach($permissions as $permission) {
            Permission::updateOrCreate([
                'name' => $permission['name'],
                'label' => $permission['label']
            ]);
        }
    }
}
