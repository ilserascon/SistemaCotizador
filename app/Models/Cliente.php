<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'nombre', 'rfc', 'razon_social', 'telefono', 'email', 'codigo_postal', 'borrado'
    ];

    // Método adicional para obtener el estado como texto
    public function getEstadoTextoAttribute()
    {
        return $this->borrado == 1 ? 'Inactivo' : 'Activo';
    }
}