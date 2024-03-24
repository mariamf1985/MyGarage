<?php

namespace Database\Factories;

use App\Models\Coche;
use App\Models\Servicio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\cita>
 */
class CitaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'description' => $this->faker->sentence(),
            'id_car'=> Coche::inRandomOrder()->first()->id,
            'id_service'=> Servicio::inRandomOrder()->first()->id,
        ];
    }
}
