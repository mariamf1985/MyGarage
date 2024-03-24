<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Coche;

class CocheControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * Test para verificar que se pueden obtener todos los coches.
     *
     * @return void
     */
    public function test_it_returns_all_coches()
    {
        
        Coche::factory()->count(3)->create();

        $response = $this->get('/api/coches');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            '*' => ['id', 'brand', 'model', 'registration_plate', 'cliente_id', 'created_at', 'updated_at'],
        ]);
    }

    /**
     * Test para verificar que se puede crear un nuevo coche.
     *
     * @return void
     */
    public function test_it_stores_a_coche()
    {
    
        $cocheData = [
            'brand' => $this->faker->word,
            'model' => $this->faker->word,
            'registration_plate' => $this->faker->unique()->bothify('??-####??'),
            'cliente_id' => 1, 
        ];

        $response = $this->post('/api/coches/coche', $cocheData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('coches', $cocheData);
    }

    /**
     * Test para verificar que se puede obtener un coche específico.
     *
     * @return void
     */
    public function test_it_shows_a_coche()
    {
        
        $coche = Coche::factory()->create();

        $response = $this->get("/api/coches/coche/{$coche->id}");

        $response->assertStatus(200);

        $response->assertJson($coche->toArray());
    }

    /**
     * Test para verificar que se puede actualizar un coche existente.
     *
     * @return void
     */
    public function test_it_updates_a_coche()
    {
        
        $coche = Coche::factory()->create();

        $updatedData = [
            'brand' => $this->faker->word,
            'model' => $this->faker->word,
            'registration_plate' => $this->faker->unique()->bothify('??-####??'),
            'cliente_id' => 1, // Ajustar según tus necesidades
        ];

        $response = $this->put("/api/coches/coche/{$coche->id}", $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('coches', $updatedData);
    }

    /**
     * Test para verificar que se puede eliminar un coche existente.
     *
     * @return void
     */
    public function test_it_deletes_a_coche()
    {
        
        $coche = Coche::factory()->create();

        $response = $this->delete("/api/coches/coche/{$coche->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('coches', ['id' => $coche->id]);
    }
}
