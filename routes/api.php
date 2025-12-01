<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\AuthController;

// --- RUTAS PÚBLICAS ---
Route::post('/login', [AuthController::class, 'login']);


// --- RUTAS PROTEGIDAS ---
Route::middleware('auth:sanctum')->group(function () {
    
    // Rutas de autenticación
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Rutas de Inventario
    Route::get('/componentes', [InventoryController::class, 'index']); 
    Route::post('/componentes', [InventoryController::class, 'store']); 

    // Rutas de Préstamos
    Route::post('/prestamos', [InventoryController::class, 'prestar']); 
    Route::get('/prestamos', [InventoryController::class, 'verPrestamos']); 
    Route::put('/prestamos/{id}/devolver', [InventoryController::class, 'devolver']); 
    
    // Ruta para obtener el usuario actual 
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/users', [InventoryController::class, 'getUsers']); 
    Route::get('/bajas', [InventoryController::class, 'getBajas']);
});