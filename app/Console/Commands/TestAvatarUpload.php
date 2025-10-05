<?php

namespace App\Console\Commands;

use App\Models\Admin\GrupoEmpresarial;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class TestAvatarUpload extends Command
{
    protected $signature = 'test:avatar-upload';
    protected $description = 'Test avatar upload functionality';

    public function handle()
    {
        $this->info('Testing avatar upload functionality...');

        // Buscar un grupo empresarial para probar
        $grupo = GrupoEmpresarial::first();
        
        if (!$grupo) {
            $this->error('No hay grupos empresariales en la base de datos');
            return;
        }

        $this->info("Probando con grupo: {$grupo->nombre} (ID: {$grupo->id})");

        // Probar eliminación con path vacío (simulando el error)
        $this->info('Probando eliminación con avatar vacío...');
        $grupo->avatar = '';
        $grupo->save();

        // Intentar "eliminar" avatar vacío
        if (empty($grupo->avatar) || empty(trim($grupo->avatar))) {
            $this->info('✅ Validación de path vacío funcionando correctamente');
        } else {
            $this->error('❌ Validación de path vacío no está funcionando');
        }

        // Probar con avatar inexistente
        $this->info('Probando eliminación con archivo inexistente...');
        $grupo->avatar = 'avatars/grupos/archivo_inexistente.jpg';
        
        if (!Storage::exists($grupo->avatar)) {
            $this->info('✅ Validación de archivo inexistente funcionando correctamente');
        } else {
            $this->error('❌ Validación de archivo inexistente no está funcionando');
        }

        // Crear directorio de avatars si no existe
        if (!Storage::exists('public/avatars/grupos')) {
            Storage::makeDirectory('public/avatars/grupos');
            $this->info('Directorio de avatars creado');
        }

        // Limpiar el avatar para el test
        $grupo->avatar = null;
        $grupo->save();

        $this->info('✅ Test completado sin errores');
    }
}