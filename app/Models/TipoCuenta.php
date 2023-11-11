<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCuenta extends Model {

    protected $table = 'tipo_cuenta';
    protected $primaryKey = 'TIPO_ID';
    public $incrementing = false; // Para indicar que no es autoincremental
    protected $keyType = 'string'; // Tipo de la clave primaria

    protected $fillable = [
        'TIPO_ID', 'TIPO_NOMBRE', 'TIPO_ESTADO',
    ];
}
