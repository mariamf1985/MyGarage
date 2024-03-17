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
        // Crear algunos servicios de prueba en la base de datos
        Servicio::factory()->count(3)->create();

        // Realizar una solicitud HTTP para obtener todos los servicios
        $response = $this->get('/api/servicios');

        // Verificar que la solicitud fue exitosa
        $response->assertStatus(200);

        // Verificar que la respuesta contiene la estructura esperada
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
        // Generar datos de servicio utilizando Faker
        $servicioData = [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence(),
        ];

        // Realizar una solicitud HTTP para almacenar un nuevo servicio
        $response = $this->post('/api/servicios/servicio', $servicioData);

        // Verificar que el servicio se almacenó correctamente
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
        // Crear un servicio de prueba en la base de datos
        $servicio = Servicio::factory()->create();

        // Realizar una solicitud HTTP para obtener los detalles del servicio específico
        $response = $this->get("/api/servicios/servicio/{$servicio->id}");

        // Verificar que la solicitud fue exitosa
        $response->assertStatus(200);

        // Verificar que la respuesta contiene los datos del servicio esperado
        $response->assertJson($servicio->toArray());
    }

    /**
     * Test para verificar que se puede actualizar un servicio existente.
     *
     * @return void
     */
    public function test_it_updates_a_servicio()
    {
        // Crear un servicio de prueba en la base de datos
        $servicio = Servicio::factory()->create();

        // Generar datos de servicio actualizados utilizando Faker
        $updatedData = [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence(),
        ];

        // Realizar una solicitud HTTP para actualizar el servicio existente
        $response = $this->put("/api/servicios/servicio/{$servicio->id}", $updatedData);

        // Verificar que la actualización se realizó correctamente
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
        // Crear un servicio de prueba en la base de datos
        $servicio = Servicio::factory()->create();

        // Realizar una solicitud HTTP para eliminar el servicio existente
        $response = $this->delete("/api/servicios/servicio/{$servicio->id}");

        // Verificar que la eliminación se realizó correctamente
        $response->assertStatus(200);
        $this->assertDatabaseMissing('servicios', ['id' => $servicio->id]);
    }
}
