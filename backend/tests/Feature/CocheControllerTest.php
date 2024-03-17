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
        // Crear algunos coches de prueba en la base de datos
        Coche::factory()->count(3)->create();

        // Realizar una solicitud HTTP para obtener todos los coches
        $response = $this->get('/api/coches');

        // Verificar que la solicitud fue exitosa
        $response->assertStatus(200);

        // Verificar que la respuesta contiene la estructura esperada
        $response->assertJsonStructure([
            '*' => ['id', 'brand', 'model', 'registration_plate', 'id_client', 'created_at', 'updated_at'],
        ]);
    }

    /**
     * Test para verificar que se puede crear un nuevo coche.
     *
     * @return void
     */
    public function test_it_stores_a_coche()
    {
        // Generar datos de coche utilizando Faker
        $cocheData = [
            'brand' => $this->faker->word,
            'model' => $this->faker->word,
            'registration_plate' => $this->faker->unique()->bothify('??-####??'),
            'id_client' => 1, // Ajustar según tus necesidades
        ];

        // Realizar una solicitud HTTP para almacenar un nuevo coche
        $response = $this->post('/api/coches/coche', $cocheData);

        // Verificar que el coche se almacenó correctamente
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
        // Crear un coche de prueba en la base de datos
        $coche = Coche::factory()->create();

        // Realizar una solicitud HTTP para obtener los detalles del coche específico
        $response = $this->get("/api/coches/coche/{$coche->id}");

        // Verificar que la solicitud fue exitosa
        $response->assertStatus(200);

        // Verificar que la respuesta contiene los datos del coche esperado
        $response->assertJson($coche->toArray());
    }

    /**
     * Test para verificar que se puede actualizar un coche existente.
     *
     * @return void
     */
    public function test_it_updates_a_coche()
    {
        // Crear un coche de prueba en la base de datos
        $coche = Coche::factory()->create();

        // Generar datos de coche actualizados utilizando Faker
        $updatedData = [
            'brand' => $this->faker->word,
            'model' => $this->faker->word,
            'registration_plate' => $this->faker->unique()->bothify('??-####??'),
            'id_client' => 1, // Ajustar según tus necesidades
        ];

        // Realizar una solicitud HTTP para actualizar el coche existente
        $response = $this->put("/api/coches/coche/{$coche->id}", $updatedData);

        // Verificar que la actualización se realizó correctamente
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
        // Crear un coche de prueba en la base de datos
        $coche = Coche::factory()->create();

        // Realizar una solicitud HTTP para eliminar el coche existente
        $response = $this->delete("/api/coches/coche/{$coche->id}");

        // Verificar que la eliminación se realizó correctamente
        $response->assertStatus(200);
        $this->assertDatabaseMissing('coches', ['id' => $coche->id]);
    }
}
