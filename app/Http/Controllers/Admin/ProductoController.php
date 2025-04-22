<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Insumo;
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
            'insumo' => 'sometimes|array',
            'insumo.*.id' => 'required|exists:insumos,id',
            'insumo.*.cantidad' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $producto = Producto::create($request->only('nombre', 'descripcion'));
            $this->syncInsumos($producto, $request->insumo);
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
            'insumo' => 'sometimes|array',
            'insumo.*.id' => 'required|exists:insumos,id',
            'insumo.*.cantidad' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $producto) {
            $producto->update($request->only('nombre', 'descripcion'));
            $this->syncInsumos($producto, $request->insumo);
        });

        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    private function syncInsumos(Producto $producto, $insumos)
    {
        ProductoInsumo::where('id_producto', $producto->id)->delete();
    
        foreach ($insumos ?? [] as $insumo) {
            ProductoInsumo::create([
                'id_producto' => $producto->id,
                'id_insumo' => $insumo['id'],
                'cantidad' => $insumo['cantidad'],
            ]);
        }
    }
}
