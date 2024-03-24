<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index(): JsonResponse
    {
    
        $servicios = Servicio::all();

        return response()->json($servicios, 200);
    }

    public function store(Request $request): JsonResponse
    {
        
        $request->validate([
            'name' => 'required|string',
        
        ]);

    
        $servicio = Servicio::create([
            'name' => $request->name,
            'description' => $request->input('description'), 
            
        ]);

        return response()->json($servicio, 201);
    }

    public function show($id): JsonResponse
    {
    
        $servicio = Servicio::find($id);

        
        if (!$servicio) {
            
            return response()->json(['error' => 'Servicio no encontrado'], 404);
        }

        
        return response()->json($servicio, 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        
        $servicio = Servicio::find($id);

        if (!$servicio) {
            
            return response()->json(['error' => 'Servicio no encontrado'], 404);
        }

        $request->validate([
            'name' => 'string',
            
        ]);

        
        $servicio->update($request->all());

        return response()->json($servicio, 200);
    }

    public function destroy($id): JsonResponse
    {
        
        $servicio = Servicio::find($id);

        if (!$servicio) {
            
            return response()->json(['error' => 'Servicio no encontrado'], 404);
        }

        $servicio->delete();

        return response()->json(['success' => 'Servicio eliminado correctamente'], 200);
    }
}