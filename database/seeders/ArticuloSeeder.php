<?php

namespace Database\Seeders;

use App\Models\Erp\Articulo;
use Illuminate\Database\Seeder;

class ArticuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articulos = [
            [
                'codigo' => 'ART-001',
                'nombre' => 'Laptop Dell Inspiron 15',
                'descripcion' => 'Laptop Dell Inspiron 15 con procesador Intel Core i5, 8GB RAM, 256GB SSD',
                'marca' => 'Dell',
                'modelo' => 'Inspiron 15',
                'unidad_medida' => 'UND',
                'precio_costo' => 1200.00,
                'precio_venta' => 1500.00,
                'stock_minimo' => 5,
                'stock_actual' => 25,
                'stock_maximo' => 50,
                'ubicacion' => 'Almacén A - Estante 1',
                'estado' => true,
                'inventariable' => true,
                'vendible' => true,
                'comprable' => true,
                'especificaciones' => [
                    'procesador' => 'Intel Core i5',
                    'ram' => '8GB',
                    'almacenamiento' => '256GB SSD',
                    'pantalla' => '15.6 pulgadas'
                ]
            ],
            [
                'codigo' => 'ART-002',
                'nombre' => 'Mouse Inalámbrico Logitech',
                'descripcion' => 'Mouse inalámbrico Logitech con tecnología óptica de alta precisión',
                'marca' => 'Logitech',
                'modelo' => 'M170',
                'unidad_medida' => 'UND',
                'precio_costo' => 15.00,
                'precio_venta' => 25.00,
                'stock_minimo' => 20,
                'stock_actual' => 150,
                'stock_maximo' => 200,
                'ubicacion' => 'Almacén A - Estante 2',
                'estado' => true,
                'inventariable' => true,
                'vendible' => true,
                'comprable' => true,
                'especificaciones' => [
                    'conectividad' => 'Inalámbrico',
                    'tecnologia' => 'Óptica',
                    'botones' => '3',
                    'color' => 'Negro'
                ]
            ],
            [
                'codigo' => 'ART-003',
                'nombre' => 'Teclado Mecánico RGB',
                'descripcion' => 'Teclado mecánico gaming con retroiluminación RGB y switches mecánicos',
                'marca' => 'Corsair',
                'modelo' => 'K55 RGB',
                'unidad_medida' => 'UND',
                'precio_costo' => 80.00,
                'precio_venta' => 120.00,
                'stock_minimo' => 10,
                'stock_actual' => 35,
                'stock_maximo' => 50,
                'ubicacion' => 'Almacén A - Estante 2',
                'estado' => true,
                'inventariable' => true,
                'vendible' => true,
                'comprable' => true,
                'especificaciones' => [
                    'tipo' => 'Mecánico',
                    'retroiluminacion' => 'RGB',
                    'switches' => 'Mecánicos',
                    'idioma' => 'Español'
                ]
            ],
            [
                'codigo' => 'ART-004',
                'nombre' => 'Monitor LED 24 pulgadas',
                'descripcion' => 'Monitor LED Full HD de 24 pulgadas con entrada HDMI y VGA',
                'marca' => 'Samsung',
                'modelo' => 'S24F350FH',
                'unidad_medida' => 'UND',
                'precio_costo' => 180.00,
                'precio_venta' => 250.00,
                'stock_minimo' => 8,
                'stock_actual' => 20,
                'stock_maximo' => 30,
                'ubicacion' => 'Almacén B - Estante 1',
                'estado' => true,
                'inventariable' => true,
                'vendible' => true,
                'comprable' => true,
                'especificaciones' => [
                    'tamaño' => '24 pulgadas',
                    'resolucion' => '1920x1080',
                    'tecnologia' => 'LED',
                    'entradas' => 'HDMI, VGA'
                ]
            ],
            [
                'codigo' => 'ART-005',
                'nombre' => 'Impresora Multifuncional HP',
                'descripcion' => 'Impresora multifuncional HP con función de impresión, escaneo y copia',
                'marca' => 'HP',
                'modelo' => 'DeskJet 2720',
                'unidad_medida' => 'UND',
                'precio_costo' => 120.00,
                'precio_venta' => 180.00,
                'stock_minimo' => 5,
                'stock_actual' => 15,
                'stock_maximo' => 25,
                'ubicacion' => 'Almacén B - Estante 2',
                'estado' => true,
                'inventariable' => true,
                'vendible' => true,
                'comprable' => true,
                'especificaciones' => [
                    'funciones' => 'Impresión, Escaneo, Copia',
                    'conectividad' => 'WiFi, USB',
                    'tipo_tinta' => 'Inyección',
                    'color' => 'Color y B/N'
                ]
            ],
            [
                'codigo' => 'ART-006',
                'nombre' => 'Disco Duro Externo 1TB',
                'descripcion' => 'Disco duro externo portátil de 1TB con conexión USB 3.0',
                'marca' => 'Seagate',
                'modelo' => 'Backup Plus Slim',
                'unidad_medida' => 'UND',
                'precio_costo' => 60.00,
                'precio_venta' => 90.00,
                'stock_minimo' => 15,
                'stock_actual' => 45,
                'stock_maximo' => 60,
                'ubicacion' => 'Almacén A - Estante 3',
                'estado' => true,
                'inventariable' => true,
                'vendible' => true,
                'comprable' => true,
                'especificaciones' => [
                    'capacidad' => '1TB',
                    'conectividad' => 'USB 3.0',
                    'tamaño' => 'Portátil',
                    'color' => 'Negro'
                ]
            ],
            [
                'codigo' => 'ART-007',
                'nombre' => 'Memoria RAM DDR4 8GB',
                'descripcion' => 'Memoria RAM DDR4 de 8GB para computadoras de escritorio',
                'marca' => 'Kingston',
                'modelo' => 'ValueRAM',
                'unidad_medida' => 'UND',
                'precio_costo' => 35.00,
                'precio_venta' => 55.00,
                'stock_minimo' => 25,
                'stock_actual' => 80,
                'stock_maximo' => 100,
                'ubicacion' => 'Almacén A - Estante 4',
                'estado' => true,
                'inventariable' => true,
                'vendible' => true,
                'comprable' => true,
                'especificaciones' => [
                    'tipo' => 'DDR4',
                    'capacidad' => '8GB',
                    'velocidad' => '2400MHz',
                    'factor_forma' => 'DIMM'
                ]
            ],
            [
                'codigo' => 'ART-008',
                'nombre' => 'Cámara Web HD',
                'descripcion' => 'Cámara web HD con micrófono integrado para videoconferencias',
                'marca' => 'Logitech',
                'modelo' => 'C270',
                'unidad_medida' => 'UND',
                'precio_costo' => 25.00,
                'precio_venta' => 40.00,
                'stock_minimo' => 15,
                'stock_actual' => 8, // Bajo stock para test
                'stock_maximo' => 30,
                'ubicacion' => 'Almacén A - Estante 2',
                'estado' => true,
                'inventariable' => true,
                'vendible' => true,
                'comprable' => true,
                'especificaciones' => [
                    'resolucion' => '720p HD',
                    'microfono' => 'Integrado',
                    'conectividad' => 'USB 2.0',
                    'montaje' => 'Clip universal'
                ]
            ],
            [
                'codigo' => 'ART-009',
                'nombre' => 'Cable HDMI 2 metros',
                'descripcion' => 'Cable HDMI de alta velocidad de 2 metros para video y audio',
                'marca' => 'Belkin',
                'modelo' => 'Ultra HD',
                'unidad_medida' => 'UND',
                'precio_costo' => 8.00,
                'precio_venta' => 15.00,
                'stock_minimo' => 30,
                'stock_actual' => 200,
                'stock_maximo' => 250,
                'ubicacion' => 'Almacén C - Estante 1',
                'estado' => true,
                'inventariable' => true,
                'vendible' => true,
                'comprable' => true,
                'especificaciones' => [
                    'longitud' => '2 metros',
                    'version' => 'HDMI 2.0',
                    'resolucion' => '4K Ultra HD',
                    'color' => 'Negro'
                ]
            ],
            [
                'codigo' => 'ART-010',
                'nombre' => 'Software Antivirus Premium',
                'descripcion' => 'Licencia de software antivirus premium para 1 año',
                'marca' => 'Norton',
                'modelo' => '360 Premium',
                'unidad_medida' => 'LIC',
                'precio_costo' => 40.00,
                'precio_venta' => 70.00,
                'stock_minimo' => 10,
                'stock_actual' => 50,
                'stock_maximo' => 100,
                'ubicacion' => 'Digital - Licencias',
                'estado' => true,
                'inventariable' => false, // Software no inventariable físicamente
                'vendible' => true,
                'comprable' => true,
                'especificaciones' => [
                    'duracion' => '1 año',
                    'dispositivos' => '5 dispositivos',
                    'tipo' => 'Licencia digital',
                    'plataformas' => 'Windows, Mac, iOS, Android'
                ]
            ]
        ];

        foreach ($articulos as $articulo) {
            Articulo::create($articulo);
        }

        // Generar datos adicionales si es necesario
        Articulo::factory()->count(60)->create();

    }
}
