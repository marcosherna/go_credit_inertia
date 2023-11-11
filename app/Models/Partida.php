<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    protected $table = 'partida';
    protected $primaryKey = 'PART_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'PART_ID',
        'PART_FECHA',
        'PART_TIPO',
        'PART_CONCEPTO',
        'PART_REGISTRO',
        'USUA_REGISTRO',
        'PART_CAMBIO',
        'USUA_MODIFICA',
        'EMPR_ID',
        'SUCU_ID',
        'PART_ESTADO',
    ];

    public function usuarioRegistro() {
        return $this->belongsTo(Empleado::class, 'USUA_REGISTRO', 'EMPL_ID');
    }

    public function empresa() {
        return $this->belongsTo(Empresa::class, 'EMPR_ID', 'EMPR_ID');
    }

    public function sucursal() {
        return $this->belongsTo(Sucursal::class, 'SUCU_ID', 'SUCU_ID');
    }
}
