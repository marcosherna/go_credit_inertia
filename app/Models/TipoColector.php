<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoColector extends Model {
    protected $table = 'tipo_colector';
    protected $primaryKey = 'TIPC_ID';
    public $incrementing = false; // Para indicar que no es autoincremental
    protected $keyType = 'string'; // Tipo de la clave primaria

    protected $fillable = [
        'TIPC_ID', 'TIPC_NOMBRE', 'TIPC_DETALLE', 'TIPC_ORDEN', 'TIPC_ESTADO',
    ];
}
