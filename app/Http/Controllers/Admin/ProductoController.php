<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Insumo;
use App\Models\ProductoInsumo;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::query();

        if ($request->filled('nombre')) {
            $query->where('nombre', 'LIKE', '%' . $request->nombre . '%');
        }

        $productos = $query->get();

        return view('admin.productos.index', compact('productos'));
    }

    public function create()
    {
        $insumos = Insumo::all();
        return view('admin.productos.create', compact('insumos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'insumos' => 'sometimes|array',
            'insumos.*.id' => 'required|exists:insumo,id',
            'insumos.*.cantidad' => 'required|numeric|min:0',
        ]);
    
        DB::transaction(function () use ($request) {
            $producto = Producto::create($request->only('nombre', 'descripcion'));
            $this->syncInsumos($producto, $request->insumos);
        });
    
        return redirect()->route('admin.productos.index')->with('success', 'Producto creado correctamente.');
    }
    public function edit($id)
    {
        $producto = Producto::with('insumos')->findOrFail($id);
        $insumos = Insumo::all();
        return view('admin.productos.edit', compact('producto', 'insumos'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'insumos' => 'sometimes|array',
            'insumos.*.id' => 'required|exists:insumo,id',
            'insumos.*.cantidad' => 'required|numeric|min:0',
        ]);
    
        DB::transaction(function () use ($request, $producto) {
            $producto->update($request->only('nombre', 'descripcion'));
            $this->syncInsumos($producto, $request->insumos);
        });
    
        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado correctamente.');
    }
    
    private function syncInsumos(Producto $producto, $insumos)
    {

        $insumoIds = collect($insumos)->pluck('id')->toArray();
    
        ProductoInsumo::where('id_producto', $producto->id)
            ->whereNotIn('id_insumo', $insumoIds)
            ->delete();
    
        foreach ($insumos ?? [] as $insumo) {
            ProductoInsumo::updateOrCreate(
                [
                    'id_producto' => $producto->id,
                    'id_insumo' => $insumo['id'],
                ],
                [
                    'cantidad' => $insumo['cantidad'],
                ]
            );
        }
    }
    public function verInsumos($id)
{
    $producto = Producto::with('insumos')->findOrFail($id);
    return view('admin.productos.insumos', compact('producto'));
}

}
