<?php

namespace App\Http\Controllers;

use App\Models\Coche;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CocheController extends Controller
{
    public function index(): JsonResponse
    {
        // Obtener todos los coches
        $coches = Coche::all();

        // Retornar una respuesta JSON con los coches
        return response()->json($coches, 200);
    }

    public function store(Request $request): JsonResponse
    {
        // Validar los datos recibidos en la solicitud
        $request->validate([
            'brand' => 'required|string',
            'model' => 'required|string',
            'registration_plate' => 'string|unique:coches,registration_plate',
            'cliente_id' => 'required|exists:clientes,id',
            // Agrega más validaciones según sea necesario
        ]);

        // Crear un nuevo coche con los datos proporcionados
        $coche = Coche::create($request->all());

        // Retornar una respuesta JSON con el coche recién creado
        return response()->json($coche, 201);
    }

    public function show($id): JsonResponse
    {
        // Buscar el coche por su ID en la base de datos
        $coche = Coche::find($id);

        // Verificar si el coche fue encontrado
        if (!$coche) {
            // Retornar una respuesta JSON con un mensaje de error si el coche no existe
            return response()->json(['error' => 'Coche no encontrado'], 404);
        }

        // Retornar una respuesta JSON con los detalles del coche encontrado
        return response()->json($coche, 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        // Buscar el coche por su ID en la base de datos
        $coche = Coche::find($id);

        // Verificar si el coche fue encontrado
        if (!$coche) {
            // Retornar una respuesta JSON con un mensaje de error si el coche no existe
            return response()->json(['error' => 'Coche no encontrado'], 404);
        }

        // Validar los datos recibidos en la solicitud
        $request->validate([
            'brand' => 'string',
            'model' => 'string',
            'registration_plate' => 'string|unique:coches,registration_plate,' . $coche->id,
            'cliente_id' => 'exists:clientes,id',
            // Agrega más validaciones según sea necesario
        ]);

        // Actualizar los campos del coche con los datos proporcionados
        $coche->update($request->all());

        // Retornar una respuesta JSON con el coche actualizado
        return response()->json($coche, 200);
    }

    public function destroy($id): JsonResponse
    {
        // Buscar el coche por su ID en la base de datos
        $coche = Coche::find($id);

        // Verificar si el coche fue encontrado
        if (!$coche) {
            // Retornar una respuesta JSON con un mensaje de error si el coche no existe
            return response()->json(['error' => 'Coche no encontrado'], 404);
        }

        // Eliminar el coche de la base de datos
        $coche->delete();

        // Retornar una respuesta JSON con un mensaje de éxito
        return response()->json(['success' => 'Coche eliminado correctamente'], 200);
    }
}