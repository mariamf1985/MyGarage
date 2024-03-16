<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index(): JsonResponse
    {
        // Obtener todos los servicios
        $servicios = Servicio::all();

        // Retornar una respuesta JSON con los servicios
        return response()->json($servicios, 200);
    }

    public function store(Request $request): JsonResponse
    {
        // Validar los datos recibidos en la solicitud
        $request->validate([
            'name' => 'required|string',
            // Eliminamos la regla de validación para la descripción
            // 'description' => 'required|string',
            // Agrega más validaciones según sea necesario
        ]);

        // Crear un nuevo servicio con los datos proporcionados
        $servicio = Servicio::create([
            'name' => $request->name,
            'description' => $request->input('description'), // Si no se proporciona, será nulo
            // Agrega más campos si es necesario
        ]);

        // Retornar una respuesta JSON con el servicio recién creado
        return response()->json($servicio, 201);
    }

    public function show($id): JsonResponse
    {
        // Buscar el servicio por su ID en la base de datos
        $servicio = Servicio::find($id);

        // Verificar si el servicio fue encontrado
        if (!$servicio) {
            // Retornar una respuesta JSON con un mensaje de error si el servicio no existe
            return response()->json(['error' => 'Servicio no encontrado'], 404);
        }

        // Retornar una respuesta JSON con los detalles del servicio encontrado
        return response()->json($servicio, 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        // Buscar el servicio por su ID en la base de datos
        $servicio = Servicio::find($id);

        // Verificar si el servicio fue encontrado
        if (!$servicio) {
            // Retornar una respuesta JSON con un mensaje de error si el servicio no existe
            return response()->json(['error' => 'Servicio no encontrado'], 404);
        }

        // Validar los datos recibidos en la solicitud
        $request->validate([
            'name' => 'string',
            // Eliminamos la regla de validación para la descripción
            // 'description' => 'string',
            // Agrega más validaciones según sea necesario
        ]);

        // Actualizar los campos del servicio con los datos proporcionados
        $servicio->update($request->all());

        // Retornar una respuesta JSON con el servicio actualizado
        return response()->json($servicio, 200);
    }

    public function destroy($id): JsonResponse
    {
        // Buscar el servicio por su ID en la base de datos
        $servicio = Servicio::find($id);

        // Verificar si el servicio fue encontrado
        if (!$servicio) {
            // Retornar una respuesta JSON con un mensaje de error si el servicio no existe
            return response()->json(['error' => 'Servicio no encontrado'], 404);
        }

        // Eliminar el servicio de la base de datos
        $servicio->delete();

        // Retornar una respuesta JSON con un mensaje de éxito
        return response()->json(['success' => 'Servicio eliminado correctamente'], 200);
    }
}