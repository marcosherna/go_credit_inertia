<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colector extends Model {

    protected $table = 'colector';
    protected $primaryKey = 'COLE_ID';
    public $incrementing = false; // Para indicar que no es autoincremental
    protected $keyType = 'string'; // Tipo de la clave primaria

    protected $fillable = [
        'COLE_ID', 'COLE_NOMBRE', 'COLE_NOMCORTO', 'COLE_LOGO', 'COLE_REF',
        'COLE_DETALLE', 'COLE_FORMULARIO', 'TIPC_ID', 'COLE_ESTADO',
    ];

    public function tipoColector() {
        return $this->belongsTo(TipoColector::class, 'TIPC_ID', 'TIPC_ID');
    }
}
