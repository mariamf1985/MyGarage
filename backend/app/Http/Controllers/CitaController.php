<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index(): JsonResponse
    {
        
        $citas = Cita::all();

        return response()->json($citas, 200);
    }

    public function store(Request $request): JsonResponse
    {
        
        $request->validate([
            'id_car' => 'required|exists:coches,id',
            'id_service' => 'required|exists:servicios,id',
            'date' => 'required|date',
            
        ]);

        $cita = Cita::create($request->all());

        return response()->json($cita, 201);
    }

    public function show($id): JsonResponse
    {
        
        $cita = Cita::find($id);

        if (!$cita) {
            
            return response()->json(['error' => 'Cita no encontrada'], 404);
        }

        return response()->json($cita, 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        
        $cita = Cita::find($id);

        if (!$cita) {
            
            return response()->json(['error' => 'Cita no encontrada'], 404);
        }


        $request->validate([
            'id_car' => 'exists:coches,id',
            'id_service' => 'exists:servicios,id',
            'date' => 'date',
            
        ]);

        $cita->update($request->all());

        return response()->json($cita, 200);
    }

    public function destroy($id): JsonResponse
    {
        
        $cita = Cita::find($id);

        if (!$cita) {
            
            return response()->json(['error' => 'Cita no encontrada'], 404);
        }

        $cita->delete();

        return response()->json(['success' => 'Cita eliminada correctamente'], 200);
    }
}