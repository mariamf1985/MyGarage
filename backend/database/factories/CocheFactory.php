<?php

namespace Database\Factories;

use App\Models\Coche;
use Illuminate\Database\Eloquent\Factories\Factory;
use GuzzleHttp\Client;

class CocheFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $client = new Client();
        $response = $client->get('https://www.carqueryapi.com/api/0.3/?cmd=getMakesAndModels');
        $data = json_decode($response->getBody(), true);
        
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
        ];
    }
}