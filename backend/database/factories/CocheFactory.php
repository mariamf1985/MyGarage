<?php

namespace Database\Factories;

use App\Models\Coche;
use Illuminate\Database\Eloquent\Factories\Factory;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use App\Models\Cliente;

class CocheFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $client = new Client(['verify' => false]); // Desactivar verificación SSL
        try {
            $response = $client->get('https://www.carqueryapi.com/api/0.3/?cmd=getMakesAndModels');
            $data = json_decode($response->getBody(), true);

            // Verificar si la clave 'Makes' está presente en la respuesta
            if (isset($data['Makes'])) {
                $makesWithModels = collect($data['Makes'])->flatMap(function ($make) {
                    return collect($make['models'])->map(function ($model) use ($make) {
                        return [
                            'make' => $make['make_display'],
                            'model' => $model['model_name'],
                        ];
                    });
                });

                $car = $makesWithModels->random();

                return [
                    'brand' => $car['make'],
                    'model' => $car['model'],
                    'registration_plate' => $this->faker->bothify('??###??'),
                    'id_client'=> Cliente::inRandomOrder()->first()->id,
                ];
            } else {
                // Manejar el caso en el que la clave 'Makes' no está presente en la respuesta
                // Por ejemplo, puedes generar datos aleatorios de forma predeterminada
                return [
                    'brand' => $this->faker->word(),
                    'model' => $this->faker->word(),
                    'registration_plate' => $this->faker->bothify('??###??'),
                    'id_client'=> Cliente::inRandomOrder()->first()->id,
                ];
            }
        } catch (RequestException $e) {
            // Manejar la excepción si ocurre algún error al hacer la solicitud
            // Por ejemplo, puedes generar datos aleatorios de forma predeterminada
            return [
                'brand' => $this->faker->word(),
                'model' => $this->faker->word(),
                'registration_plate' => $this->faker->bothify('??###??'),
                'id_client'=> Cliente::inRandomOrder()->first()->id,
            ];
        }
    }
}