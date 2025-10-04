<?php

namespace Database\Seeders;

use App\Models\Admin\LeadCliente;
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

        $userfirst = User::factory(1)->create([
            'name' => 'Neskenz',
            'email' => 'joelneskenz@gmail.com',
            'password' => bcrypt('password'),
            'estado' => 1,
            'is_owner' => '1',
        ]);

        User::factory(100)->create();

        $this->call([
            // modelos
            PaisSeeder::class,
            EmpresaSeeder::class,
            SedesSeeder::class,
            TipoLocalSeeder::class,
            LocalSeeder::class,
            GrupoEmpresarialSeeder::class,
            ArticuloSeeder::class,
            LeadClienteSeeder::class,
            DemoDataSeeder::class,

            // permisos
            RolePermissionSeeder::class,
            GrupoEmpresarialPermissionsSeeder::class,
            EmpresaPermissionsSeeder::class,
            SedesPermissionsSeeder::class,
            LocalPermissionsSeeder::class,
            ArticuloPermissionsSeeder::class,
            LeadClientePermissionsSeeder::class,

            SuperAdminSeeder::class, // Agregar al final para que tenga todos los roles disponibles
        ]);

        // actualizar usuario
        $userfirst[0]->assignRole('admin');
        $userfirst[0]->estado = 1;
        $userfirst[0]->is_owner = 1;
        $userfirst[0]->grupo_empresarial_id = 1;
        $userfirst[0]->empresa_id = 1;

        $userfirst[0]->save();
        
    }
}
