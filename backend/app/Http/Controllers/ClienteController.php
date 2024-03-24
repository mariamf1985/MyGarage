<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ClienteController extends Controller
{
    public function index(): JsonResponse
    {
    
        $clientes = Cliente::with('coches')->get();

        return response()->json($clientes, 200);
    }

    public function store(Request $request): JsonResponse
    {
        
        $request->validate([
            'name' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'email|unique:clientes,email',
        ]);

       
        $cliente = Cliente::create([
            'name' => $request->name,
            'surname' => $request->input('surname'), 
            'phone_number' => $request->phone_number,
            'email' => $request->email,
        ]);

    
        return response()->json($cliente, 201);
    }

    public function show($id): JsonResponse
    {
        
        $cliente = Cliente::find($id);

        
        if (!$cliente) {
            
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        return response()->json($cliente, 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        
        $cliente = Cliente::find($id);

        
        if (!$cliente) {
            
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        
        $request->validate([
            'name' => 'string',
            'surname' => 'string',
            'phone_number' => 'string',
            'email' => 'email|unique:clientes,email,' . $cliente->id, 
        ]);

        
        $cliente->update($request->all());

        return response()->json($cliente, 200);
    }

    public function destroy($id): JsonResponse
    {
        
        $cliente = Cliente::find($id);

        
        if (!$cliente) {
            
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        
        $cliente->delete();

        
        return response()->json(['success' => 'Cliente eliminado correctamente'], 200);
    }
}
