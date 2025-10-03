<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeadClientePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'lead-cliente.view' => 'Ver leads clientes',
            'lead-cliente.create' => 'Crear leads clientes',
            'lead-cliente.edit' => 'Editar leads clientes',
            'lead-cliente.delete' => 'Eliminar leads clientes',
            'lead-cliente.dar-de-alta' => 'Dar de alta leads clientes',
        ];

        foreach ($permissions as $permission => $description) {
            \Spatie\Permission\Models\Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        // Asignar permisos al rol Admin (si existe)
        $adminRole = \Spatie\Permission\Models\Role::where('name', 'Admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo(array_keys($permissions));
        }
    }
}
