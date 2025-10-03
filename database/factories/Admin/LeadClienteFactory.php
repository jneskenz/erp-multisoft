<?php

namespace Database\Factories\Admin;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class LeadClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa' => $this->faker->company(),
            'ruc' => $this->faker->unique()->numerify('###########'), // 11 dígitos
            'rubro_empresa' => $this->faker->word(),
            'descripcion' => $this->faker->sentence(),
            'pais' => $this->faker->country(),
            'nro_empleados' => $this->faker->numberBetween(1, 500),
            'cliente' => $this->faker->name(),
            'nro_documento' => $this->faker->unique()->numerify('#########'), // 9 dígitos
            'telefono' => $this->faker->phoneNumber(),
            'correo' => $this->faker->unique()->safeEmail(),
            'estado' => $this->faker->boolean(80), // 80% de probabilidad de ser true
        ];
    }
}
