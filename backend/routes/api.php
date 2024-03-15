<?php

use App\Http\Controllers\CocheController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;

Route::prefix('clientes')->group(function () {
    Route::get('/', [ClienteController::class, 'index']);
    Route::post('/', [ClienteController::class, 'store']);
    Route::get('/{id}', [ClienteController::class, 'show']);
    Route::put('/{id}', [ClienteController::class, 'update']);
    Route::delete('/{id}', [ClienteController::class, 'destroy']);
});

Route::prefix('coches')->group(function () {
    Route::get('/', [CocheController::class, 'index']);
    Route::post('/', [CocheController::class, 'store']);
    Route::get('/{id}', [CocheController::class, 'show']);
    Route::put('/{id}', [CocheController::class, 'update']);
    Route::delete('/{id}', [CocheController::class, 'destroy']);
});

Route::prefix('servicios')->group(function () {
    Route::get('/', [ServicioController::class, 'index']);
    Route::post('/', [ServicioController::class, 'store']);
    Route::get('/{id}', [ServicioController::class, 'show']);
    Route::put('/{id}', [ServicioController::class, 'update']);
    Route::delete('/{id}', [ServicioController::class, 'destroy']);
});

Route::prefix('citas')->group(function () {
    Route::get('/', [CitaController::class, 'index']);
    Route::post('/', [CitaController::class, 'store']);
    Route::get('/{id}', [CitaController::class, 'show']);
    Route::put('/{id}', [CitaController::class, 'update']);
    Route::delete('/{id}', [CitaController::class, 'destroy']);
});