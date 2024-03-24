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
    
        Cita::factory()->count(3)->create();

        $response = $this->get('/api/citas');

        $response->assertStatus(200);

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
    
        $citaData = [
            'id_car' => $this->faker->numberBetween(1, 10),
            'id_service' => $this->faker->numberBetween(1, 10),
            'date' => $this->faker->date(),
            'description' => $this->faker->sentence(),
        ];

        
        $response = $this->post('/api/citas/cita', $citaData);

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
    
    $cita = Cita::factory()->create();

    
    $response = $this->get("/api/citas/cita/{$cita->id}");

    $response->assertStatus(200);

    $citaArray = $cita->toArray();
    $citaArray['date'] = \Carbon\Carbon::parse($citaArray['date'])->format('Y-m-d H:i:s');

    $response->assertJsonFragment($citaArray);
}

    /**
     * Test para verificar que se puede actualizar una cita existente.
     *
     * @return void
     */
    public function test_it_updates_a_cita()
    {
        
        $cita = Cita::factory()->create();

        $updatedData = [
            'id_car' => $this->faker->numberBetween(1, 10),
            'id_service' => $this->faker->numberBetween(1, 10),
            'date' => $this->faker->date(),
            'description' => $this->faker->sentence(),
        ];

        $response = $this->put("/api/citas/cita/{$cita->id}", $updatedData);

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
        
        $cita = Cita::factory()->create();

        $response = $this->delete("/api/citas/cita/{$cita->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('citas', ['id' => $cita->id]);
    }
}
