<?php

namespace App\Console\Commands;

use App\Models\Admin\GrupoEmpresarial;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;

class TestImageUpload extends Command
{
    protected $signature = 'test:image-upload';
    protected $description = 'Test image upload simulation';

    public function handle()
    {
        $this->info('Simulando subida de imagen...');

        // Crear imagen de prueba
        $imagePath = storage_path('app/test-image.png');
        
        // Crear una imagen PNG simple (1x1 pixel transparente)
        $imageData = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChAHPn+YCVAAAAABJRU5ErkJggg==');
        file_put_contents($imagePath, $imageData);
        
        $this->info("Imagen de prueba creada: {$imagePath}");
        
        // Probar guardado directo
        $grupo = GrupoEmpresarial::first();
        if (!$grupo) {
            $this->error('No hay grupos empresariales');
            return;
        }
        
        $fileName = 'avatars/grupos/' . $grupo->id . '_' . time() . '.png';
        
        try {
            // Copiar archivo al storage
            $success = Storage::disk('public')->put($fileName, file_get_contents($imagePath));
            
            if ($success) {
                $this->info("✅ Archivo guardado exitosamente: {$fileName}");
                
                // Actualizar en base de datos
                $grupo->update(['avatar' => $fileName]);
                $this->info("✅ Avatar actualizado en base de datos");
                
                // Verificar URL
                $url = $grupo->avatar_url;
                $this->info("URL del avatar: {$url}");
                
            } else {
                $this->error("❌ Falló el guardado del archivo");
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Error: " . $e->getMessage());
        }
        
        // Limpiar archivo temporal
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
}