<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model {

    protected $table = 'sucursal';
    protected $primaryKey = 'SUCU_ID';
    public $incrementing = false; // Para indicar que no es autoincremental
    protected $keyType = 'string'; // Tipo de la clave primaria

    protected $fillable = [
        'SUCU_ID', 'SUCU_NOMBRE', 'MUNI_ID', 'SUCU_DIRECCION', 'SUCU_TEL', 'SUCU_MAIL',
        'SUCU_IMAGEN', 'SUCU_IMAGEN2', 'EMPR_ID', 'SUCU_ESTADO',
    ];

    public function municipio() {
        return $this->belongsTo(Municipio::class, 'MUNI_ID', 'MUNI_ID');
    }

    public function empresa() {
        return $this->belongsTo(Empresa::class, 'EMPR_ID', 'EMPR_ID');
    }
}
