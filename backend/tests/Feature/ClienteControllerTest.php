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
        // Crear algunos clientes de prueba en la base de datos
        Cliente::factory()->count(3)->create();

        // Realizar una solicitud HTTP para obtener todos los clientes
        $response = $this->get('/api/clientes');

        // Verificar que la solicitud fue exitosa
        $response->assertStatus(200);

        // Verificar que la respuesta contiene la estructura esperada
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
        // Generar datos de cliente utilizando Faker
        $clienteData = [
            'name' => $this->faker->firstName,
            'surname' => $this->faker->lastName,
            'phone_number' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
        ];

        // Realizar una solicitud HTTP para almacenar un nuevo cliente
        $response = $this->post('/api/clientes/cliente', $clienteData);

        // Verificar que el cliente se almacenó correctamente
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
        // Crear un cliente de prueba en la base de datos
        $cliente = Cliente::factory()->create();

        // Realizar una solicitud HTTP para obtener los detalles del cliente específico
        $response = $this->get("/api/clientes/cliente/{$cliente->id}");

        // Verificar que la solicitud fue exitosa
        $response->assertStatus(200);

        // Verificar que la respuesta contiene los datos del cliente esperado
        $response->assertJson($cliente->toArray());
    }

    /**
     * Test para verificar que se puede actualizar un cliente existente.
     *
     * @return void
     */
    public function test_it_updates_a_cliente()
    {
        // Crear un cliente de prueba en la base de datos
        $cliente = Cliente::factory()->create();

        // Generar datos de cliente actualizados utilizando Faker
        $updatedData = [
            'name' => $this->faker->firstName,
            'surname' => $this->faker->lastName,
            'phone_number' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
        ];

        // Realizar una solicitud HTTP para actualizar el cliente existente
        $response = $this->put("/api/clientes/cliente/{$cliente->id}", $updatedData);

        // Verificar que la actualización se realizó correctamente
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
        // Crear un cliente de prueba en la base de datos
        $cliente = Cliente::factory()->create();

        // Realizar una solicitud HTTP para eliminar el cliente existente
        $response = $this->delete("/api/clientes/cliente/{$cliente->id}");

        // Verificar que la eliminación se realizó correctamente
        $response->assertStatus(200);
        $this->assertDatabaseMissing('clientes', ['id' => $cliente->id]);
    }
}
