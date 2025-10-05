<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixWorkspaceRoutes extends Command
{
    protected $signature = 'fix:workspace-routes';
    protected $description = 'Fix workspace route references to use proper workspace prefixes';

    public function handle()
    {
        $this->info('Fixing workspace route references...');

        // Archivos del workspace que necesitan ser actualizados
        $workspaceFiles = [
            'resources/views/apps/workspace/empresas/index.blade.php',
            'resources/views/apps/workspace/empresas/create.blade.php',
            'resources/views/apps/workspace/empresas/edit.blade.php',
            'resources/views/apps/workspace/empresas/show.blade.php',
            'resources/views/apps/workspace/empresas/form.blade.php',
        ];

        $replacements = [
            // Cambiar rutas de empresas
            "route('empresas.index')" => "route('workspace.empresas.index', ['grupoempresa' => \$grupoActual->slug ?? request()->route('grupoempresa')])",
            "route('empresas.create')" => "route('workspace.empresas.create', ['grupoempresa' => \$grupoActual->slug ?? request()->route('grupoempresa')])",
            "route('empresas.store')" => "route('workspace.empresas.store', ['grupoempresa' => \$grupoActual->slug ?? request()->route('grupoempresa')])",
            "route('empresas.show'," => "route('workspace.empresas.show', ['grupoempresa' => \$grupoActual->slug ?? request()->route('grupoempresa'),",
            "route('empresas.edit'," => "route('workspace.empresas.edit', ['grupoempresa' => \$grupoActual->slug ?? request()->route('grupoempresa'),",
            "route('empresas.update'," => "route('workspace.empresas.update', ['grupoempresa' => \$grupoActual->slug ?? request()->route('grupoempresa'),",
            "route('empresas.destroy'," => "route('workspace.empresas.destroy', ['grupoempresa' => \$grupoActual->slug ?? request()->route('grupoempresa'),",
            
            // Cambiar routeIs
            "request()->routeIs('empresas.*')" => "request()->routeIs('workspace.empresas.*')",
        ];

        $totalChanges = 0;

        foreach ($workspaceFiles as $file) {
            $fullPath = base_path($file);
            
            if (!File::exists($fullPath)) {
                $this->warn("Archivo no encontrado: {$file}");
                continue;
            }

            $content = File::get($fullPath);
            $originalContent = $content;
            
            foreach ($replacements as $search => $replace) {
                $content = str_replace($search, $replace, $content);
            }
            
            if ($content !== $originalContent) {
                File::put($fullPath, $content);
                $changes = substr_count($originalContent, "route('empresas.") - substr_count($content, "route('empresas.");
                $totalChanges += abs($changes);
                $this->info("✅ Actualizado: {$file}");
            } else {
                $this->line("⚪ Sin cambios: {$file}");
            }
        }

        $this->info("🎉 Proceso completado. Total de cambios realizados: {$totalChanges}");
        
        $this->line('');
        $this->info('Ahora las rutas del workspace usarán el formato correcto:');
        $this->line('  Antes: /empresas?grupoempresa=1');
        $this->line('  Ahora: /nombre-del-grupo/empresas');
    }
}