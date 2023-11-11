<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaSucursal extends Model {

    protected $table = 'cuenta_sucursal';
    protected $primaryKey = 'CUEN_ID';
    public $incrementing = false; // Para indicar que no es autoincremental
    protected $keyType = 'string'; // Tipo de la clave primaria

    protected $fillable = [
        'CUEN_ID', 'CUEN_CONTA', 'CUEN_NOMBRE', 'CUEN_SALDO', 'CUEN_TIPO', 'CUEN_CLASIF',
        'CUEN_CUENTA', 'CUEN_MODO', 'CUEN_PADRE', 'SUCU_ID', 'CUEN_FECHA', 'CUEN_HORA', 'CUEN_ESTADO',
    ];

    public function sucursal() {
        return $this->belongsTo(Sucursal::class, 'SUCU_ID', 'SUCU_ID');
    }
}
