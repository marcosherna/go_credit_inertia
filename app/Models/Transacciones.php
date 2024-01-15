<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transacciones extends Model {
    protected $table = 'transacciones';
    protected $primaryKey = 'TRAN_ID';
    public $incrementing = false; // Para indicar que no es autoincremental
    protected $keyType = 'string'; // Tipo de la clave primaria

    protected $fillable = [
        'TRAN_ID', 'TIPT_ID', 'TRAN_FECHA', 'TRAN_HORA', 'TRAN_MONTO',
        'TRAN_DETALLE', 'TRAN_REFERENCIA', 'TRAN_RESPUESTA', 'TRAN_ESTADO', 'TRAN_USUARIO',
    ];

    public function tipoTransaccion() {
        return $this->belongsTo(TipoTransaccion::class, 'TIPT_ID', 'TIPT_ID');
    }

    public function insert() {
        DB::table($this->table)->insert($this->toArray());
    }
}
