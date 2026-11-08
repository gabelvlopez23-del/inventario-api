<?php

use App\Http\Controllers\Api\ProductoController;
use Illuminate\Support\Facades\Route;

// Esta línea crea automáticamente todas las rutas REST (GET, POST, PUT, DELETE)
Route::apiResource('productos', ProductoController::class);
