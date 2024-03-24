<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Cliente;

class ClienteControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * Test para verificar que se pueden obtener todos los clientes.
     *
     * @return void
     */
    public function test_it_returns_all_clientes()
    {
        
        Cliente::factory()->count(3)->create();

        $response = $this->get('/api/clientes');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            '*' => ['id', 'name', 'surname', 'phone_number', 'email', 'created_at', 'updated_at'],
        ]);
    }

    /**
     * Test para verificar que se puede crear un nuevo cliente.
     *
     * @return void
     */
    public function test_it_stores_a_cliente()
    {
        
        $clienteData = [
            'name' => $this->faker->firstName,
            'surname' => $this->faker->lastName,
            'phone_number' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
        ];

        
        $response = $this->post('/api/clientes/cliente', $clienteData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('clientes', $clienteData);
    }

    /**
     * Test para verificar que se puede obtener un cliente específico.
     *
     * @return void
     */
    public function test_it_shows_a_cliente()
    {
        
        $cliente = Cliente::factory()->create();

        $response = $this->get("/api/clientes/cliente/{$cliente->id}");

        $response->assertStatus(200);

        $response->assertJson($cliente->toArray());
    }

    /**
     * Test para verificar que se puede actualizar un cliente existente.
     *
     * @return void
     */
    public function test_it_updates_a_cliente()
    {
        
        $cliente = Cliente::factory()->create();

        $updatedData = [
            'name' => $this->faker->firstName,
            'surname' => $this->faker->lastName,
            'phone_number' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
        ];

        $response = $this->put("/api/clientes/cliente/{$cliente->id}", $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('clientes', $updatedData);
    }

    /**
     * Test para verificar que se puede eliminar un cliente existente.
     *
     * @return void
     */
    public function test_it_deletes_a_cliente()
    {
        
        $cliente = Cliente::factory()->create();

        $response = $this->delete("/api/clientes/cliente/{$cliente->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('clientes', ['id' => $cliente->id]);
    }
}
