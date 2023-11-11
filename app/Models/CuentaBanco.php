<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class CuentaBanco extends Model {

    use HasUlids;
    protected $table = 'cuenta_banco';
    protected $primaryKey = 'CUEB_NUMERO';
    public $incrementing = false; // Para indicar que no es autoincremental
    protected $keyType = 'string'; // Tipo de la clave primaria
    public $timestamps = false; // Para indicar que no hay timestamps

    protected $fillable = [
        'CUEB_NUMERO', 
        'CUEB_DETALLE', 
        'CUEN_ID', 
        'BANC_ID', 
        'TIPC_ID', 
        'CUEB_ESTADO',
    ];

    public function cuentaSucursal() {
        return $this->belongsTo(CuentaSucursal::class, 'CUEN_ID', 'CUEN_ID');
    }

    public function banco() {
        return $this->belongsTo(Banco::class, 'BANC_ID', 'BANC_ID');
    }

    public function tipoCuenta() {
        return $this->belongsTo(TipoCuenta::class, 'TIPC_ID', 'TIPO_ID');
    }

    public function InsertQuerySql(){ 
        try {
            DB::table($this->table)->insert($this->toArray());
        } catch (\Throwable $th) {
            dump($th->getMessage());
        }
        
    }
}
