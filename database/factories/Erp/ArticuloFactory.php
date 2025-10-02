<?php

namespace Database\Factories\Erp;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Erp\Articulo>
 */
class ArticuloFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo' => strtoupper($this->faker->unique()->bothify('ART-####')),
            'nombre' => $this->faker->words(3, true),
            'descripcion' => $this->faker->sentence(),
            'marca' => $this->faker->company(),
            'modelo' => $this->faker->word(),
            'unidad_medida' => $this->faker->randomElement(['unidad', 'kg', 'litro', 'metro']),
            'precio_costo' => $this->faker->randomFloat(2, 10, 1000),
            'precio_venta' => $this->faker->randomFloat(2, 20, 2000),
            'stock_minimo' => $this->faker->numberBetween(1, 50),
            'stock_actual' => $this->faker->numberBetween(50, 500),
            'stock_maximo' => $this->faker->numberBetween(500, 1000),
            'ubicacion' => $this->faker->word(),
            'imagen' => null,
            'especificaciones' => [
                'color' => $this->faker->safeColorName(),
                'peso' => $this->faker->randomFloat(2, 0.1, 10) . ' kg',
                'dimensiones' => $this->faker->randomFloat(2, 1, 100) . ' x ' . $this->faker->randomFloat(2, 1, 100) . ' x ' . $this->faker->randomFloat(2, 1, 100) . ' cm',
            ],
            'estado' => true,
            'inventariable' => true,
            'vendible' => true,
            'comprable' => true,
            'categoria_id' => null,
            'proveedor_id' => null,
        ];
    }
}
