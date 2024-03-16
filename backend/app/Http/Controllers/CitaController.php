<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index(): JsonResponse
    {
        // Obtener todas las citas
        $citas = Cita::all();

        // Retornar una respuesta JSON con las citas
        return response()->json($citas, 200);
    }

    public function store(Request $request): JsonResponse
    {
        // Validar los datos recibidos en la solicitud
        $request->validate([
            'id_car' => 'required|exists:coches,id',
            'id_service' => 'required|exists:servicios,id',
            'date' => 'required|date',
            // Eliminamos la regla de validación para la descripción
            // 'description' => 'string',
            // Agrega más validaciones según sea necesario
        ]);

        // Crear una nueva cita con los datos proporcionados
        $cita = Cita::create($request->all());

        // Retornar una respuesta JSON con la cita recién creada
        return response()->json($cita, 201);
    }

    public function show($id): JsonResponse
    {
        // Buscar la cita por su ID en la base de datos
        $cita = Cita::find($id);

        // Verificar si la cita fue encontrada
        if (!$cita) {
            // Retornar una respuesta JSON con un mensaje de error si la cita no existe
            return response()->json(['error' => 'Cita no encontrada'], 404);
        }

        // Retornar una respuesta JSON con los detalles de la cita encontrada
        return response()->json($cita, 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        // Buscar la cita por su ID en la base de datos
        $cita = Cita::find($id);

        // Verificar si la cita fue encontrada
        if (!$cita) {
            // Retornar una respuesta JSON con un mensaje de error si la cita no existe
            return response()->json(['error' => 'Cita no encontrada'], 404);
        }

        // Validar los datos recibidos en la solicitud
        $request->validate([
            'id_car' => 'exists:coches,id',
            'id_service' => 'exists:servicios,id',
            'date' => 'date',
            // Eliminamos la regla de validación para la descripción
            // 'description' => 'string',
            // Agrega más validaciones según sea necesario
        ]);

        // Actualizar los campos de la cita con los datos proporcionados
        $cita->update($request->all());

        // Retornar una respuesta JSON con la cita actualizada
        return response()->json($cita, 200);
    }

    public function destroy($id): JsonResponse
    {
        // Buscar la cita por su ID en la base de datos
        $cita = Cita::find($id);

        // Verificar si la cita fue encontrada
        if (!$cita) {
            // Retornar una respuesta JSON con un mensaje de error si la cita no existe
            return response()->json(['error' => 'Cita no encontrada'], 404);
        }

        // Eliminar la cita de la base de datos
        $cita->delete();

        // Retornar una respuesta JSON con un mensaje de éxito
        return response()->json(['success' => 'Cita eliminada correctamente'], 200);
    }
}