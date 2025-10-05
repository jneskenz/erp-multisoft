<?php

namespace App\Console\Commands;

use App\Models\Admin\GrupoEmpresarial;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class TestFileUpload extends Command
{
    protected $signature = 'test:file-upload';
    protected $description = 'Test file upload storage functionality';

    public function handle()
    {
        $this->info('Testing file upload storage functionality...');

        // Verificar permisos de storage
        $storagePath = storage_path('app/public/avatars/grupos');
        $this->info("Storage path: {$storagePath}");
        
        if (!is_dir($storagePath)) {
            $this->info('Creando directorio...');
            mkdir($storagePath, 0755, true);
        }

        if (!is_writable($storagePath)) {
            $this->error("❌ El directorio {$storagePath} no tiene permisos de escritura");
            return;
        } else {
            $this->info("✅ El directorio tiene permisos de escritura");
        }

        // Probar escritura de archivo de prueba
        $testFile = $storagePath . '/test.txt';
        if (file_put_contents($testFile, 'test content')) {
            $this->info("✅ Archivo de prueba creado exitosamente");
            unlink($testFile);
        } else {
            $this->error("❌ No se pudo crear archivo de prueba");
        }

        // Verificar configuración de storage
        $this->info("Storage disk default: " . config('filesystems.default'));
        $this->info("Storage disk public: " . config('filesystems.disks.public.root'));

        // Probar Storage facade
        try {
            Storage::disk('public')->put('test-upload.txt', 'contenido de prueba');
            $this->info("✅ Storage facade funcionando");
            Storage::disk('public')->delete('test-upload.txt');
        } catch (\Exception $e) {
            $this->error("❌ Error con Storage facade: " . $e->getMessage());
        }

        // Verificar grupo empresarial
        $grupo = GrupoEmpresarial::first();
        if ($grupo) {
            $this->info("Grupo de prueba: {$grupo->nombre} (ID: {$grupo->id})");
        } else {
            $this->error("❌ No hay grupos empresariales para probar");
        }

        $this->info('✅ Test de storage completado');
    }
}