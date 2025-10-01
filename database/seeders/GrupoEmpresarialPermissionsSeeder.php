<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GrupoEmpresarialPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear permisos para Grupo Empresarial
        $permissions = [
            'grupo_empresarial.view' => 'Ver grupo empresarial',
            'grupo_empresarial.create' => 'Crear grupo empresarial',
            'grupo_empresarial.edit' => 'Editar grupo empresarial',
            'grupo_empresarial.delete' => 'Eliminar grupo empresarial',
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

        // Asignar permisos básicos al rol User (si existe)
        $userRole = \Spatie\Permission\Models\Role::where('name', 'User')->first();
        if ($userRole) {
            $userRole->givePermissionTo(['grupo_empresarial.view']);
        }

        $this->command->info('Permisos de Grupo Empresarial creados exitosamente.');


        

    }
}
