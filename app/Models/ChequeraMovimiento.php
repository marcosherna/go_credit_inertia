<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ChequeraMovimiento extends Model
{
    protected $table = 'chequera_movimiento';
    public $timestamps = false; // Si no necesitas campos created_at y updated_at
    public $incrementing = false;
    public $keyType = 'string';
    public $primaryKey = 'CHEM_ID';

    protected $fillable = [
        'CHEM_ID',
        'CHEQ_ID',
        'CHEM_NUMERO',
        'CHEM_FECHA',
        'CHEM_LUGAR',
        'CHEM_MONTO',
        'CHEM_NOMBRE',
        'CHEM_MONTOLETRA',
        'CHEM_COMENTARIOS',
        'CHEM_FECHACAMBIO',
        'USUA_ID',
        'CHEM_ESTADO',
    ];

    public function chequera() {
        return $this->belongsTo(Chequera::class, 'CHEQ_ID', 'CHEQ_ID');
    }

    public function usuario() {
        return $this->belongsTo(Empleado::class, 'USUA_ID', 'EMPL_ID');
    }

    public function emitCheque() {
        DB::transaction(function () {
            if ($this->chequera->CHEQ_PENDIENTES >= 1) {   
                $data = $this->toArray();
                unset($data['chequera']); // Eliminar la clave 'chequera'
                DB::table($this->table)->insert($data);
                $this->chequera->CHEQ_PENDIENTES = intval($this->chequera->CHEQ_PENDIENTES) - 1;
                $this->chequera->CHEQ_VERIFICADOR = $this->CHEM_NUMERO;
                $this->chequera->save();
            }

            if($this->chequera->CHEQ_PENDIENTES == 0){
                $this->chequera->CHEQ_ESTADO = 2;
                $this->chequera->save();
            }
        });
    }

    public function obtenerEstado(){
        $estadoCheque = [
            '0' => 'Generado',
            '1' => 'Transito',
            '2' => 'Pagado',
            '3' => 'Anulado',
        ];
        return $estadoCheque[$this->CHEM_ESTADO];
    }
}
