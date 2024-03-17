<?php

namespace Tests\Feature;

//use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Cita;

class CitaControllerTest extends TestCase
{
    //use RefreshDatabase;
    use DatabaseTransactions;
    use WithFaker;

    /**
     * Test para verificar que se pueden obtener todas las citas.
     *
     * @return void
     */
    public function test_it_returns_all_citas()
    {
        // Crear algunas citas de prueba en la base de datos
        Cita::factory()->count(3)->create();

        // Realizar una solicitud HTTP para obtener todas las citas
        $response = $this->get('/api/citas');

        // Verificar que la solicitud fue exitosa
        $response->assertStatus(200);

        // Verificar que la respuesta contiene la estructura esperada
        $response->assertJsonStructure([
            '*' => ['id', 'id_car', 'id_service', 'date', 'description', 'created_at', 'updated_at'],
        ]);
    }

    /**
     * Test para verificar que se puede crear una nueva cita.
     *
     * @return void
     */
    public function test_it_stores_a_cita()
    {
        // Generar datos de cita utilizando Faker
        $citaData = [
            'id_car' => $this->faker->numberBetween(1, 10),
            'id_service' => $this->faker->numberBetween(1, 10),
            'date' => $this->faker->date(),
            'description' => $this->faker->sentence(),
        ];

        // Realizar una solicitud HTTP para almacenar una nueva cita
        $response = $this->post('/api/citas/cita', $citaData);

        // Verificar que la cita se almacenó correctamente
        $response->assertStatus(201);
        $this->assertDatabaseHas('citas', $citaData);
    }

    /**
     * Test para verificar que se puede obtener una cita específica.
     *
     * @return void
     */
    public function test_it_shows_a_cita()
{
    // Crear una cita de prueba en la base de datos
    $cita = Cita::factory()->create();

    // Realizar una solicitud HTTP para obtener los detalles de la cita específica
    $response = $this->get("/api/citas/cita/{$cita->id}");

    // Verificar que la solicitud fue exitosa
    $response->assertStatus(200);

    // Reformatear la fecha en el array $cita->toArray() para que coincida con el formato de fecha en la respuesta JSON
    $citaArray = $cita->toArray();
    $citaArray['date'] = \Carbon\Carbon::parse($citaArray['date'])->format('Y-m-d H:i:s');

    // Verificar que la respuesta contiene los datos de la cita esperada
    $response->assertJsonFragment($citaArray);
}

    /**
     * Test para verificar que se puede actualizar una cita existente.
     *
     * @return void
     */
    public function test_it_updates_a_cita()
    {
        // Crear una cita de prueba en la base de datos
        $cita = Cita::factory()->create();

        // Generar datos de cita actualizados utilizando Faker
        $updatedData = [
            'id_car' => $this->faker->numberBetween(1, 10),
            'id_service' => $this->faker->numberBetween(1, 10),
            'date' => $this->faker->date(),
            'description' => $this->faker->sentence(),
        ];

        // Realizar una solicitud HTTP para actualizar la cita existente
        $response = $this->put("/api/citas/cita/{$cita->id}", $updatedData);

        // Verificar que la actualización se realizó correctamente
        $response->assertStatus(200);
        $this->assertDatabaseHas('citas', $updatedData);
    }

    /**
     * Test para verificar que se puede eliminar una cita existente.
     *
     * @return void
     */
    public function test_it_deletes_a_cita()
    {
        // Crear una cita de prueba en la base de datos
        $cita = Cita::factory()->create();

        // Realizar una solicitud HTTP para eliminar la cita existente
        $response = $this->delete("/api/citas/cita/{$cita->id}");

        // Verificar que la eliminación se realizó correctamente
        $response->assertStatus(200);
        $this->assertDatabaseMissing('citas', ['id' => $cita->id]);
    }
}
