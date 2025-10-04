<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\GrupoEmpresarial;

class GrupoEmpresarialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grupos = [
            [
                'user_uuid' => \Illuminate\Support\Str::uuid()->toString(),
                'nombre' => 'Grupo Multisoft',
                'descripcion' => 'Grupo empresarial líder en soluciones tecnológicas y software empresarial',
                'codigo' => 'GMS001',
                'pais_origen' => 'Perú',
                'telefono' => '+51 1 234-5678',
                'email' => 'contacto@grupomultisoft.com',
                'sitio_web' => 'https://www.grupomultisoft.com',
                'direccion_matriz' => 'Av. Javier Prado Este 1234, San Isidro, Lima, Perú',
                'estado' => true,
                'slug' => 'grupo-multisoft'
            ],
            [
                'user_uuid' => \Illuminate\Support\Str::uuid()->toString(),
                'nombre' => 'Corporación Innovación',
                'descripcion' => 'Corporación especializada en innovación tecnológica y transformación digital',
                'codigo' => 'CORP001',
                'pais_origen' => 'Colombia',
                'telefono' => '+57 1 987-6543',
                'email' => 'info@corporacioninnovacion.com',
                'sitio_web' => 'https://www.corporacioninnovacion.com',
                'direccion_matriz' => 'Carrera 15 #93-47, Bogotá, Colombia',
                'estado' => true,
                'slug' => 'corporacion-innovacion'
            ],
            [
                'user_uuid' => \Illuminate\Support\Str::uuid()->toString(),
                'nombre' => 'Holding Empresarial SA',
                'descripcion' => 'Holding empresarial con inversiones en múltiples sectores económicos',
                'codigo' => 'HOLD001',
                'pais_origen' => 'Chile',
                'telefono' => '+56 2 2345-6789',
                'email' => 'contacto@holdingempresarial.cl',
                'sitio_web' => 'https://www.holdingempresarial.cl',
                'direccion_matriz' => 'Av. Providencia 1234, Providencia, Santiago, Chile',
                'estado' => true,
                'slug' => 'holding-empresarial'
            ]
        ];

        foreach ($grupos as $grupo) {
            GrupoEmpresarial::create($grupo);
        }

    }
}
