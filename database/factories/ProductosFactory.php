<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Productos>
 */
class ProductosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre_producto' => $this->faker->sentence(),
            'detalles_producto' => $this->faker->sentence(),
            'id_categoria' => $this->faker->randomElement([1,2,3]),
            'id_proveedor' => 1
        ];
    }
}
