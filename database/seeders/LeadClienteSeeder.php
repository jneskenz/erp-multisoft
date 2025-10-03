<?php

namespace Database\Seeders;

use App\Models\Admin\LeadCliente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeadClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        LeadCliente::create([
            'empresa' => 'Empresa 1',
            'ruc' => '12345678901',
            'rubro_empresa' => 'Tecnología',
            'nro_empleados' => 50,
            'pais' => 'Perú',
            'descripcion' => 'Empresa dedicada a soluciones tecnológicas.',
            'cliente' => 'Juan Pérez',
            'nro_documento' => '12345678',
            'correo' => 'juan.perez@example.com',
            'telefono' => '987654321',
            'cargo' => 'Gerente',
            'plan_interes' => 'Premium',
            'estado' => true
        ]);

        LeadCliente::create([
            'empresa' => 'Empresa 2',
            'ruc' => '10987654321',
            'rubro_empresa' => 'Comercio',
            'nro_empleados' => 20,
            'pais' => 'Chile',
            'descripcion' => 'Empresa de comercio electrónico.',
            'cliente' => 'María Gómez',
            'nro_documento' => '87654321',
            'correo' => 'maria.gomez@example.com',
            'telefono' => '123456789',
            'cargo' => 'Directora de Ventas',
            'plan_interes' => 'Básico',
            'estado' => true
        ]);

        LeadCliente::factory(150)->create();

        $this->command->info('LeadClientes creados exitosamente.');


    }
}
