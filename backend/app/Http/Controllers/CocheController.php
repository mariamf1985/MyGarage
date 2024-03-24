<?php

namespace App\Http\Controllers;

use App\Models\Coche;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CocheController extends Controller
{
    public function index(): JsonResponse
    {
        
        $coches = Coche::all();

        return response()->json($coches, 200);
    }

    public function store(Request $request): JsonResponse
    {
        
        $request->validate([
            'brand' => 'required|string',
            'model' => 'required|string',
            'registration_plate' => 'string|unique:coches,registration_plate',
            'cliente_id' => 'required|exists:clientes,id',
            
        ]);

        $coche = Coche::create($request->all());

        return response()->json($coche, 201);
    }

    public function show($id): JsonResponse
    {
    
        $coche = Coche::find($id);

        if (!$coche) {

            return response()->json(['error' => 'Coche no encontrado'], 404);
        }

        return response()->json($coche, 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
    
        $coche = Coche::find($id);

        if (!$coche) {
            
            return response()->json(['error' => 'Coche no encontrado'], 404);
        }

        $request->validate([
            'brand' => 'string',
            'model' => 'string',
            'registration_plate' => 'string|unique:coches,registration_plate,' . $coche->id,
            'cliente_id' => 'exists:clientes,id',
        
        ]);

        $coche->update($request->all());

        return response()->json($coche, 200);
    }

    public function destroy($id): JsonResponse
    {
        
        $coche = Coche::find($id);

        if (!$coche) {
    
            return response()->json(['error' => 'Coche no encontrado'], 404);
        }

        $coche->delete();

        return response()->json(['success' => 'Coche eliminado correctamente'], 200);
    }
}