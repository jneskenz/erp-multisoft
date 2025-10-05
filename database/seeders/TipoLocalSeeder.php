<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Workspace\TipoLocal;

class TipoLocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipoLocales = [
            [
                'nombre' => 'Principal',
                'descripcion' => 'Local principal de la empresa',
                'estado' => true
            ],
            [
                'nombre' => 'Sucursal',
                'descripcion' => 'Local sucursal',
                'estado' => true
            ],
            [
                'nombre' => 'Almacén',
                'descripcion' => 'Local destinado para almacenamiento',
                'estado' => true
            ],
            [
                'nombre' => 'Showroom',
                'descripcion' => 'Local de exhibición y ventas',
                'estado' => true
            ]
        ];

        foreach ($tipoLocales as $tipo) {
            TipoLocal::create($tipo);
        }
    }
}
