<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ClienteController extends Controller
{
    public function index(): JsonResponse
    {
        // Obtener todos los clientes junto con sus coches relacionados
        $clientes = Cliente::with('coches')->get();

        // Retornar la respuesta JSON con los clientes y sus coches
        return response()->json($clientes, 200);
    }

    public function store(Request $request): JsonResponse
    {
        // Validar los datos recibidos en la solicitud
        $request->validate([
            'name' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'email|unique:clientes,email',
        ]);

        // Crear un nuevo cliente con los datos proporcionados
        $cliente = Cliente::create([
            'name' => $request->name,
            'surname' => $request->input('surname'), // Si no se proporciona, será nulo
            'phone_number' => $request->phone_number,
            'email' => $request->email,
        ]);

        // Retornar una respuesta JSON con el cliente recién creado
        return response()->json($cliente, 201);
    }

    public function show($id): JsonResponse
    {
        // Buscar el cliente por su ID en la base de datos
        $cliente = Cliente::find($id);

        // Verificar si el cliente fue encontrado
        if (!$cliente) {
            // Retornar una respuesta JSON con un mensaje de error si el cliente no existe
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        // Retornar una respuesta JSON con los detalles del cliente encontrado
        return response()->json($cliente, 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        // Buscar el cliente por su ID en la base de datos
        $cliente = Cliente::find($id);

        // Verificar si el cliente fue encontrado
        if (!$cliente) {
            // Retornar una respuesta JSON con un mensaje de error si el cliente no existe
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        // Validar los datos recibidos en la solicitud
        $request->validate([
            'name' => 'string',
            'surname' => 'string',
            'phone_number' => 'string',
            'email' => 'email|unique:clientes,email,' . $cliente->id, // Ignorar el email actual del cliente
            // Agrega más validaciones según sea necesario
        ]);

        // Actualizar los campos del cliente con los datos proporcionados
        $cliente->update($request->all());

        // Retornar una respuesta JSON con el cliente actualizado
        return response()->json($cliente, 200);
    }

    public function destroy($id): JsonResponse
    {
        // Buscar el cliente por su ID en la base de datos
        $cliente = Cliente::find($id);

        // Verificar si el cliente fue encontrado
        if (!$cliente) {
            // Retornar una respuesta JSON con un mensaje de error si el cliente no existe
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        // Eliminar el cliente de la base de datos
        $cliente->delete();

        // Retornar una respuesta JSON con un mensaje de éxito
        return response()->json(['success' => 'Cliente eliminado correctamente'], 200);
    }
}
