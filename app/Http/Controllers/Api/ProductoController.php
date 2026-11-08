<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Events\ProductoActualizado; // <-- Importamos tu evento de WebSockets
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/productos
     */
    public function index()
    {
        return response()->json(Producto::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/productos
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        $producto = Producto::create($datos);

        // Activamos el WebSocket para avisar que hay un producto nuevo
        event(new ProductoActualizado($producto));

        return response()->json($producto, 201);
    }

    /**
     * Display the specified resource.
     * GET /api/productos/{id}
     */
    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        return response()->json($producto, 200);
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH /api/productos/{id}
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0'
        ]);

        $producto->update($datos);

        // 🔥 Activamos el WebSocket para avisar que el producto cambió (ej: el stock)
        event(new ProductoActualizado($producto));

        return response()->json($producto, 200);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/productos/{id}
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        
        return response()->json(null, 204);
    }
}
