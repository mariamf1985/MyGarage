<?php

use App\Http\Controllers\CocheController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;

Route::prefix('clientes')->group(function () {
    Route::get('/', [ClienteController::class, 'index']);
    Route::post('/cliente', [ClienteController::class, 'store']);
    Route::get('/cliente/{id}', [ClienteController::class, 'show']);
    Route::put('/cliente/{id}', [ClienteController::class, 'update']);
    Route::delete('/cliente/{id}', [ClienteController::class, 'destroy']);
});

Route::prefix('coches')->group(function () {
    Route::get('/', [CocheController::class, 'index']);
    Route::post('/coche', [CocheController::class, 'store']);
    Route::get('/coche/{id}', [CocheController::class, 'show']);
    Route::put('/coche/{id}', [CocheController::class, 'update']);
    Route::delete('/coche/{id}', [CocheController::class, 'destroy']);
});

Route::prefix('servicios')->group(function () {
    Route::get('/', [ServicioController::class, 'index']);
    Route::post('/servicio', [ServicioController::class, 'store']);
    Route::get('/servicio/{id}', [ServicioController::class, 'show']);
    Route::put('/servicio/{id}', [ServicioController::class, 'update']);
    Route::delete('/servicio/{id}', [ServicioController::class, 'destroy']);
});

Route::prefix('citas')->group(function () {
    Route::get('/', [CitaController::class, 'index']);
    Route::post('/cita', [CitaController::class, 'store']);
    Route::get('/cita/{id}', [CitaController::class, 'show']);
    Route::put('/cita/{id}', [CitaController::class, 'update']);
    Route::delete('/cita/{id}', [CitaController::class, 'destroy']);
});