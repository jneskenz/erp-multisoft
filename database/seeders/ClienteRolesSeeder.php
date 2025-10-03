<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ClienteRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear permisos específicos para el ERP de clientes basados en las rutas reales
        $permisos = [
            // Dashboard y perfil
            'home.view',
            'users.view',
            'users.edit',
            'users.create',
            'users.delete',
            
            // Empresas - Gestión de la propia empresa
            'empresas.view',
            'empresas.create',
            'empresas.edit',
            'empresas.update',
            'empresas.delete',
            
            // Artículos/Inventario
            'articulos.view',
            'articulos.create',
            'articulos.edit',
            'articulos.update',
            'articulos.delete',
            'articulos.toggle-status',
            
            // Locales/Sucursales
            'locales.view',
            'locales.create',
            'locales.edit',
            'locales.update',
            'locales.delete',
            'locales.toggle-status',
            
            // Sedes
            'sedes.view',
            'sedes.create',
            'sedes.edit',
            'sedes.update',
            'sedes.delete',
            
            // Roles y permisos (limitado)
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.update',
            'roles.delete',
            
            // Customización
            'customization.view',
            'customization.update',
            'customization.reset',
            'customization.settings',
        ];

        // Crear permisos si no existen
        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso, 'guard_name' => 'web']);
        }

        // Crear roles para clientes del ERP
        $this->createClienteERPRoles();
    }

    private function createClienteERPRoles()
    {
        // Role Cliente Demo - Acceso muy limitado por 30 días
        $roleDemo = Role::firstOrCreate(['name' => 'cliente_demo', 'guard_name' => 'web']);
        $roleDemo->syncPermissions([
            'home.view',
            'users.view',
            'empresas.view',
            'articulos.view',
            'locales.view',
        ]);

        // Role Cliente Básico - Funcionalidades básicas del ERP
        $roleBasico = Role::firstOrCreate(['name' => 'cliente_basico', 'guard_name' => 'web']);
        $roleBasico->syncPermissions([
            'home.view',
            'users.view',
            'users.edit',
            'empresas.view',
            'empresas.edit',
            'empresas.update',
            'articulos.view',
            'articulos.create',
            'articulos.edit',
            'articulos.update',
            'locales.view',
            'locales.create',
            'locales.edit',
            'locales.update',
            'customization.view',
        ]);

        // Role Cliente Profesional - Funcionalidades avanzadas
        $roleProfesional = Role::firstOrCreate(['name' => 'cliente_profesional', 'guard_name' => 'web']);
        $roleProfesional->syncPermissions([
            'home.view',
            'users.view',
            'users.edit',
            'users.create',
            'empresas.view',
            'empresas.edit',
            'empresas.update',
            'articulos.view',
            'articulos.create',
            'articulos.edit',
            'articulos.update',
            'articulos.delete',
            'articulos.toggle-status',
            'locales.view',
            'locales.create',
            'locales.edit',
            'locales.update',
            'locales.delete',
            'locales.toggle-status',
            'sedes.view',
            'sedes.create',
            'sedes.edit',
            'sedes.update',
            'customization.view',
            'customization.update',
        ]);

        // Role Cliente Empresarial - Acceso completo al ERP (excepto admin)
        $roleEmpresarial = Role::firstOrCreate(['name' => 'cliente_empresarial', 'guard_name' => 'web']);
        $permisosERP = Permission::whereNotIn('name', [
            // Excluir permisos de admin
            'admin.logs.view',
            'admin.logs.delete',
            'admin.grupo-empresarial.view',
            'admin.grupo-empresarial.edit',
            'admin.grupo-empresarial.delete',
            'lead_cliente.view',
            'lead_cliente.create',
            'lead_cliente.edit',
            'lead_cliente.delete',
        ])->get();
        $roleEmpresarial->syncPermissions($permisosERP);

        $this->command->info('Roles de cliente ERP creados exitosamente:');
        $this->command->info('- cliente_demo: Acceso de solo lectura (30 días)');
        $this->command->info('- cliente_basico: Gestión básica de empresa e inventario');
        $this->command->info('- cliente_profesional: Funciones avanzadas + gestión completa');
        $this->command->info('- cliente_empresarial: Acceso completo al ERP (sin admin)');
    }
}
