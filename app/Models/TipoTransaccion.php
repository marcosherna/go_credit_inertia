<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoTransaccion extends Model {

    protected $table = 'tipo_transaccion';
    protected $primaryKey = 'TIPT_ID';
    public $incrementing = false; // Para indicar que no es autoincremental
    protected $keyType = 'string'; // Tipo de la clave primaria

    protected $fillable = [
        'TIPT_ID', 'TIPT_NOMBRE', 'TIPT_DETALLE', 'COLE_ID', 'TIPT_MOVIMIENTO',
        'CUEN_ID', 'TIPT_FACTURABLE', 'CUEN_FACTURAR', 'TIPT_ESTADO',
    ];

    public function colector() {
        return $this->belongsTo(Colector::class, 'COLE_ID', 'COLE_ID');
    }

    public function cuentaRelacionada() {
        return $this->belongsTo(CuentaSucursal::class, 'CUEN_ID', 'CUEN_ID');
    }

    public function cuentaFacturar() {
        return $this->belongsTo(CuentaSucursal::class, 'CUEN_FACTURAR', 'CUEN_ID');
    }
}
