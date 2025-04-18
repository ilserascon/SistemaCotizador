<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Almacen;

class AlmacenController extends Controller
{
    public function index(Request $request) // <-- Aquí se agrega el parámetro
    {
        $query = Almacen::query();

        if ($request->has('nombre') && $request->nombre != '') {
            $query->where('nombre', 'LIKE', '%' . $request->nombre . '%');
        }
    
        $almacenes = $query->get(); // Resultados filtrados
    
        return view('admin.almacenes.index', compact('almacenes'));
    }

    public function create()
    {
        return view('admin.almacenes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
        ]);

        Almacen::create($request->all());

        return redirect()->route('admin.almacenes.index')->with('success', 'Almacén creado correctamente.');
    }

    public function edit(Almacen $almacen)
    {
        return view('admin.almacenes.edit', compact('almacen'));
    }

    public function update(Request $request, Almacen $almacen)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
        ]);

        $almacen->update($request->all());

        return redirect()->route('admin.almacenes.index')->with('success', 'Almacén actualizado.');
    }
}
