<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    use HasFactory;

    protected $table = 'insumo';

    protected $fillable = [
        'nombre',
        'id_tipo_insumo',
        'id_proveedor',
        'costo',
        'precio_publico',
        'utilidad',
        'campo1',
        'campo2',
        'campo3',
        'campo4',
        'campo5',
        'campo6',
        'campo7',
        'campo8',
    ];

    public function tipoInsumo()
    {
        return $this->belongsTo(TipoInsumo::class, 'id_tipo_insumo');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;
}
