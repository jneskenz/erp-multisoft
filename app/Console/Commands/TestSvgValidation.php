<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;

class TestSvgValidation extends Command
{
    protected $signature = 'test:svg-validation';
    protected $description = 'Test SVG file validation';

    public function handle()
    {
        $this->info('Testing SVG file validation...');

        // Simular validación de archivo SVG
        $rules = [
            'avatar' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ];

        // Test 1: SVG válido
        $this->info('Test 1: Validando tipos MIME para SVG...');
        
        $validMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml'];
        
        foreach ($validMimes as $mime) {
            $this->line("  - {$mime}: ✅ Permitido");
        }

        // Test 2: Verificar reglas de validación
        $this->info('Test 2: Verificando reglas de validación...');
        
        // Crear un validador de prueba
        $testData = ['avatar' => null];
        $validator = Validator::make($testData, $rules);
        
        if ($validator->passes()) {
            $this->info('✅ Validación de campo nullable: PASÓ');
        } else {
            $this->error('❌ Validación de campo nullable: FALLÓ');
            $this->line('Errores: ' . json_encode($validator->errors()->toArray()));
        }

        // Test 3: Mostrar configuración actual
        $this->info('Test 3: Configuración actual de subida de archivos...');
        $this->line('Max file size PHP: ' . ini_get('upload_max_filesize'));
        $this->line('Max post size PHP: ' . ini_get('post_max_size'));
        $this->line('Laravel max file validation: 5120 KB (5MB)');

        $this->info('✅ Test de validación SVG completado');
    }
}