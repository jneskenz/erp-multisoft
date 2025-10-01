<?php

namespace Database\Factories\Admin;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin\GrupoEmpresarial>
 */
class GrupoEmpresarialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'nombre' => $this->faker->company(),
            'descripcion' => $this->faker->optional()->paragraph(),
            'codigo' => strtoupper($this->faker->unique()->bothify('???###')),
            'pais_origen' => $this->faker->optional()->country(),
            'telefono' => $this->faker->optional()->phoneNumber(),
            'email' => $this->faker->optional()->companyEmail(),
            'sitio_web' => $this->faker->optional()->url(),
            'direccion_matriz' => $this->faker->optional()->address(),
            'estado' => $this->faker->boolean(80), // 80% de probabilidad de ser true 

        ];
    }
}
