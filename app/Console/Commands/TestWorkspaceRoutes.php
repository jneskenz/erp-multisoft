<?php

namespace App\Console\Commands;

use App\Models\Admin\GrupoEmpresarial;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class TestWorkspaceRoutes extends Command
{
    protected $signature = 'test:workspace-routes';
    protected $description = 'Test workspace route generation';

    public function handle()
    {
        $this->info('Testing workspace route generation...');

        // Obtener un grupo empresarial para testing
        $grupo = GrupoEmpresarial::first();
        
        if (!$grupo) {
            $this->error('No hay grupos empresariales para probar');
            return;
        }

        $this->info("Probando con grupo: {$grupo->nombre} (Slug: {$grupo->slug})");
        
        // Probar generación de rutas
        $routes = [
            'workspace.empresas.index',
            'workspace.empresas.create',
            'workspace.customization.index',
        ];

        foreach ($routes as $routeName) {
            try {
                $url = route($routeName, ['grupoempresa' => $grupo->slug]);
                $this->info("✅ {$routeName}: {$url}");
            } catch (\Exception $e) {
                $this->error("❌ {$routeName}: Error - {$e->getMessage()}");
            }
        }

        $this->line('');
        $this->info('Formato de URL esperado:');
        $this->line("  http://tu-dominio.test/ws/{$grupo->slug}/empresas");
        $this->line("  http://tu-dominio.test/ws/{$grupo->slug}/customization");
        
        $this->line('');
        $this->info('✅ Test de rutas completado');
    }
}