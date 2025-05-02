<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Insumo;
use App\Models\TipoInsumo;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class InsumoController extends Controller
{
    public function index(Request $request)
{
    $tipos = TipoInsumo::all();

    $tipoSeleccionado = $request->get('tipo_insumo');
    
    $query = Insumo::with(['tipoInsumo', 'proveedor']);
    
    $camposDinamicos = [];

    if ($tipoSeleccionado) {
        $tipo = TipoInsumo::find($tipoSeleccionado);

        if ($tipo) {
            foreach ($tipo->getAttributes() as $campo => $valor) {
                if (str_starts_with($campo, 'campo') && !empty($valor)) {
                    $camposDinamicos[$campo] = $valor;
                }
            }
        }

        $query->where('id_tipo_insumo', $tipoSeleccionado);
    }

    $insumos = $query->get();

    return view('admin.insumos.index', compact('insumos', 'tipos', 'tipoSeleccionado', 'camposDinamicos'));
}

    
    public function create()
    {
        $proveedores = Proveedor::all();
        $tiposInsumo = TipoInsumo::all()->map(function($tipo) {
            $campos = [];
            for ($i = 1; $i <= 8; $i++) {
                $campo = 'campo'.$i;
                if (!empty($tipo->$campo)) {
                    $campos[$campo] = $tipo->$campo;
                }
            }
            $tipo->campos_data = $campos;
            return $tipo;
        });
        
        return view('admin.insumos.create', compact('proveedores', 'tiposInsumo'));
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'id_proveedor' => 'required|exists:proveedores,id',
            'id_tipo_insumo' => 'required|exists:tipo_insumo,id',
            'costo' => 'required|numeric',
            'precio_publico' => 'required|numeric',
            'utilidad' => 'required|numeric',
            'campo1' => 'nullable|string',
            'campo2' => 'nullable|string',
            'campo3' => 'nullable|string',
            'campo4' => 'nullable|string',
            'campo5' => 'nullable|string',
            'campo6' => 'nullable|string',
            'campo7' => 'nullable|string',
            'campo8' => 'nullable|string',
        ]);
    
        $insumo = new Insumo();
        $insumo->nombre = $request->nombre;
        $insumo->id_proveedor = $request->id_proveedor;
        $insumo->id_tipo_insumo = $request->id_tipo_insumo;
        $insumo->costo = $request->costo;
        $insumo->precio_publico = $request->precio_publico;
        $insumo->utilidad = $request->utilidad;
    
        $insumo->campo1 = $request->campo1 ?? null;
        $insumo->campo2 = $request->campo2 ?? null;
        $insumo->campo3 = $request->campo3 ?? null;
        $insumo->campo4 = $request->campo4 ?? null;
        $insumo->campo5 = $request->campo5 ?? null;
        $insumo->campo6 = $request->campo6 ?? null;
        $insumo->campo7 = $request->campo7 ?? null;
        $insumo->campo8 = $request->campo8 ?? null;
    
        $insumo->save();
    
        return redirect()->route('admin.insumos.index')->with('success', 'Insumo creado exitosamente');
    }

    public function edit($id)
    {
        $insumo = Insumo::findOrFail($id);
        $proveedores = Proveedor::all();
        $tipos = TipoInsumo::all();
        $tipo = $insumo->tipoInsumo;

        $camposDinamicos = [];

        if ($tipo) {
            foreach ($tipo->getAttributes() as $campo => $valor) {
                if (str_starts_with($campo, 'campo') && !empty($valor)) {
                    $camposDinamicos[$campo] = $valor;
                }
            }
        }

        return view('admin.insumos.edit', compact('insumo', 'proveedores', 'tipos', 'camposDinamicos'));
    }


    public function update(Request $request, Insumo $insumo)
    {
        $validated = $request->validate([
            'nombre'           => 'required|string|max:255',
            'id_tipo_insumo'   => 'required|exists:tipo_insumo,id',
            'id_proveedor'     => 'required|exists:proveedores,id',
            'costo'            => 'nullable|numeric',
            'precio_publico'   => 'nullable|numeric',
            'utilidad'         => 'nullable|numeric',
            'campo1'           => 'nullable|string|max:255',
            'campo2'           => 'nullable|string|max:255',
            'campo3'           => 'nullable|string|max:255',
            'campo4'           => 'nullable|string|max:255',
            'campo5'           => 'nullable|string|max:255',
            'campo6'           => 'nullable|string|max:255',
            'campo7'           => 'nullable|string|max:255',
            'campo8'           => 'nullable|string|max:255',
        ]);

        $insumo->update($validated);

        return redirect()->route('admin.insumos.index')->with('success', 'Insumo actualizado correctamente');
    }
}
