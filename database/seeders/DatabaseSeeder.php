<?php

namespace Database\Seeders;

use App\Models\Erp\TipoLocal;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(100)->create();

        $this->call([
            // modelos
            PaisSeeder::class,
            EmpresaSeeder::class,
            SedesSeeder::class,
            TipoLocalSeeder::class,
            LocalSeeder::class,
            GrupoEmpresarialSeeder::class,

            // permisos
            RolePermissionSeeder::class,
            GrupoEmpresarialPermissionsSeeder::class,
            EmpresaPermissionsSeeder::class,
            SedesPermissionsSeeder::class,
            LocalPermissionsSeeder::class,

            SuperAdminSeeder::class, // Agregar al final para que tenga todos los roles disponibles
        ]);
        
    }
}
