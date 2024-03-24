<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Servicio;

class ServicioControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * Test para verificar que se pueden obtener todos los servicios.
     *
     * @return void
     */
    public function test_it_returns_all_servicios()
    {
        
        Servicio::factory()->count(3)->create();

        $response = $this->get('/api/servicios');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            '*' => ['id', 'name', 'description', 'created_at', 'updated_at'],
        ]);
    }

    /**
     * Test para verificar que se puede crear un nuevo servicio.
     *
     * @return void
     */
    public function test_it_stores_a_servicio()
    {
        
        $servicioData = [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence(),
        ];

        
        $response = $this->post('/api/servicios/servicio', $servicioData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('servicios', $servicioData);
    }

    /**
     * Test para verificar que se puede obtener un servicio específico.
     *
     * @return void
     */
    public function test_it_shows_a_servicio()
    {
        
        $servicio = Servicio::factory()->create();

        $response = $this->get("/api/servicios/servicio/{$servicio->id}");

        $response->assertStatus(200);

        $response->assertJson($servicio->toArray());
    }

    /**
     * Test para verificar que se puede actualizar un servicio existente.
     *
     * @return void
     */
    public function test_it_updates_a_servicio()
    {
        
        $servicio = Servicio::factory()->create();

        $updatedData = [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence(),
        ];

        $response = $this->put("/api/servicios/servicio/{$servicio->id}", $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('servicios', $updatedData);
    }

    /**
     * Test para verificar que se puede eliminar un servicio existente.
     *
     * @return void
     */
    public function test_it_deletes_a_servicio()
    {
    
        $servicio = Servicio::factory()->create();

        $response = $this->delete("/api/servicios/servicio/{$servicio->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('servicios', ['id' => $servicio->id]);
    }
}
