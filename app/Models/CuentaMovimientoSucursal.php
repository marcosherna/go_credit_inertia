<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaMovimientoSucursal extends Model
{
    protected $table = 'cuenta_movimiento_sucursal';
    protected $primaryKey = 'CUEM_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'CUEM_ID',
        'CUEN_ID',
        'PART_ID',
        'CUEM_FECHA',
        'CUEM_HORA',
        'CUEM_TIPOMOV',
        'CUEM_SALDOINI',
        'CUEM_ABONO',
        'CUEM_CARGO',
        'CUEM_SALDOFIN',
        'CUEM_DETALLE',
        'CUEM_ESTADO',
        'USUA_LOGIN',
    ];

    public function cuentaSucursal() {
        return $this->belongsTo(CuentaSucursal::class, 'CUEN_ID', 'CUEN_ID');
    }

    public function partida() {
        return $this->belongsTo(Partida::class, 'PART_ID', 'PART_ID');
    }

    public function usuario() {
        return $this->belongsTo(Usuarios::class, 'USUA_LOGIN', 'USUA_LOGIN');
    }
}
