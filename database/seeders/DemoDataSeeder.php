<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Admin\GrupoEmpresarial;
use App\Models\Workspace\Empresa;

/**
 * Seeder de Datos de Demostración del ERP Multi-Empresa
 * 
 * Fecha de creación: 3 de octubre de 2025
 * 
 * Este seeder crea datos de prueba completos para el sistema ERP multi-empresa
 */
class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Iniciando creación de datos de demostración...');
        
        // 1. Crear roles de cliente
        $this->createClientRoles();
        
        // 2. Crear grupo empresarial
        $grupoDemo = $this->createDemoGroup();
        
        // 3. Crear empresas
        $empresas = $this->createDemoCompanies($grupoDemo);
        
        // 4. Crear usuarios
        $this->createDemoUsers($grupoDemo, $empresas);
        
        $this->command->info('✅ Datos de demostración creados exitosamente!');
        $this->showCredentials();
    }

    private function createClientRoles(): void
    {
        $this->command->info('📋 Creando roles de cliente...');
        
        $roles = [
            'cliente_demo' => 'Cliente con acceso de demostración',
            'cliente_basico' => 'Cliente con plan básico del ERP', 
            'cliente_profesional' => 'Cliente con plan profesional del ERP',
            'cliente_empresarial' => 'Cliente con plan empresarial completo'
        ];

        foreach ($roles as $nombre => $descripcion) {
            Role::firstOrCreate(['name' => $nombre], ['guard_name' => 'web']);
            $this->command->line("  - Rol creado: {$nombre}");
        }
    }

    private function createDemoGroup(): GrupoEmpresarial
    {
        $this->command->info('🏢 Creando grupo empresarial...');
        
        $grupo = GrupoEmpresarial::updateOrCreate(
            ['slug' => 'demo'],
            [
                'id' => 269,
                'slug' => 'demo',
                'codigo' => 'demo',
                'user_uuid' => Str::uuid()->toString(),
                'nombre' => 'Grupo Empresarial Demo',
                'descripcion' => 'Grupo de demostración para testing',
                'estado' => true
            ]
        );

        $this->command->line("  - Grupo creado: {$grupo->nombre}");
        return $grupo;
    }

    private function createDemoCompanies(GrupoEmpresarial $grupo): array
    {
        $this->command->info('🏪 Creando empresas...');
        
        $empresasData = [
            ['id' => 169, 'codigo' => 'alpha', 'slug' => 'empresa-alpha', 'nombre' => 'Empresa Alpha'],
            ['id' => 170, 'codigo' => 'beta', 'slug' => 'empresa-beta', 'nombre' => 'Empresa Beta'],
            ['id' => 171, 'codigo' => 'gamma', 'slug' => 'empresa-gamma', 'nombre' => 'Empresa Gamma']
        ];

        $empresas = [];
        foreach ($empresasData as $data) {
            $empresa = Empresa::updateOrCreate(
                ['slug' => $data['slug'], 'grupo_empresarial_id' => $grupo->id],
                [
                    'id' => $data['id'],
                    'razon_social' => $data['nombre'],
                    'nombre_comercial' => $data['nombre'],
                    'numerodocumento' => '900123456-' . $data['id'],
                    'slug' => $data['slug'],
                    'codigo' => $data['codigo'],
                    'estado' => true
                ]
            );
            
            $empresas[] = $empresa;
            $this->command->line("  - Empresa: {$empresa->razon_social} (/{$grupo->slug}/{$empresa->slug})");
        }

        return $empresas;
    }

    private function createDemoUsers(GrupoEmpresarial $grupo, array $empresas): void
    {
        $this->command->info('👥 Creando usuarios...');
        
        $usuariosData = [
            ['id' => 106, 'name' => 'Juan Pérez', 'email' => 'juan@alpha.com', 'empresa' => $empresas[0], 'role' => 'cliente_demo'],
            ['id' => 107, 'name' => 'María González', 'email' => 'maria@beta.com', 'empresa' => $empresas[1], 'role' => 'cliente_basico'],
            ['id' => 108, 'name' => 'Carlos Rodríguez', 'email' => 'carlos@gamma.com', 'empresa' => $empresas[2], 'role' => 'cliente_profesional']
        ];

        foreach ($usuariosData as $userData) {
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'id' => $userData['id'],
                    'name' => $userData['name'],
                    'password' => Hash::make('demo123'),
                    'grupo_empresarial_id' => $grupo->id,
                    'empresa_id' => $userData['empresa']->id,
                    'email_verified_at' => now()
                ]
            );

            $user->syncRoles([$userData['role']]);
            $this->command->line("  - Usuario: {$user->name} ({$user->email})");
        }
    }

    private function showCredentials(): void
    {
        $this->command->info('');
        $this->command->info('🔑 CREDENCIALES DE DEMOSTRACIÓN:');
        $this->command->info('Email: juan@alpha.com | Password: demo123 | URL: /demo/empresa-alpha');
        $this->command->info('Email: maria@beta.com | Password: demo123 | URL: /demo/empresa-beta');
        $this->command->info('Email: carlos@gamma.com | Password: demo123 | URL: /demo/empresa-gamma');
        $this->command->info('');
    }
}
