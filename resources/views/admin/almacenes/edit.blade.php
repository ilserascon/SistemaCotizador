@extends('layouts.stisla')

@section('title', 'Editar Almacén')

@section('content')
<div class="section">
    <div class="section-header">
        <h1>Editar Almacén</h1>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.almacenes.update', $almacen->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                                value="{{ old('nombre', $almacen->nombre) }}" required>
                        @error('nombre') 
                            <div class="invalid-feedback">{{ $message }}</div> 
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="ubicacion">Ubicación</label>
                        <input name="ubicacion" class="form-control @error('ubicacion') is-invalid @enderror"
                                value="{{ old('ubicacion', $almacen->ubicacion) }}" required>
                        @error('ubicacion') 
                            <div class="invalid-feedback">{{ $message }}</div> 
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <a href="{{ route('admin.almacenes.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
