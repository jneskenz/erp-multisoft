<?php

namespace App\Console\Commands;

use App\Models\Admin\GrupoEmpresarial;
use App\Models\Workspace\Empresa;
use Illuminate\Console\Command;

class TestEmpresaBinding extends Command
{
    protected $signature = 'test:empresa-binding';
    protected $description = 'Test empresa route model binding';

    public function handle()
    {
        $this->info('Testing empresa route model binding...');

        // Obtener una empresa de prueba
        $empresa = Empresa::first();
        
        if (!$empresa) {
            $this->error('No hay empresas para probar');
            return;
        }

        $this->info("Empresa encontrada: {$empresa->nombre_comercial} (ID: {$empresa->id})");

        // Obtener un grupo empresarial
        $grupo = GrupoEmpresarial::first();
        
        if (!$grupo) {
            $this->error('No hay grupos empresariales');
            return;
        }

        $this->info("Grupo encontrado: {$grupo->nombre} (Slug: {$grupo->slug})");

        // Probar generación de rutas
        try {
            $editUrl = route('workspace.empresas.edit', [
                'grupoempresa' => $grupo->slug,
                'empresa' => $empresa->id
            ]);
            $this->info("✅ URL Edit generada: {$editUrl}");

            $showUrl = route('workspace.empresas.show', [
                'grupoempresa' => $grupo->slug,
                'empresa' => $empresa->id
            ]);
            $this->info("✅ URL Show generada: {$showUrl}");

            $updateUrl = route('workspace.empresas.update', [
                'grupoempresa' => $grupo->slug,
                'empresa' => $empresa->id
            ]);
            $this->info("✅ URL Update generada: {$updateUrl}");

        } catch (\Exception $e) {
            $this->error("❌ Error: {$e->getMessage()}");
        }

        $this->info('✅ Test completado');
    }
}