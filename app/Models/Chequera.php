<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PhpParser\ErrorHandler\Throwing;

class Chequera extends Model {

    use HasUlids;
    protected $table = 'chequera';
    public $timestamps = false; // Si no necesitas campos created_at y updated_at
    protected $primaryKey = 'CHEQ_ID'; 
    public $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'CHEQ_ID',
        'CUEB_NUMERO',
        'CHEQ_DESDE',
        'CHEQ_HASTA',
        'CHEQ_CANTIDAD',
        'CHEQ_PENDIENTES',
        'CHEQ_REFERENCIA',
        'CHEQ_FECHA',
        'CHEQ_GENERACION',
        'CHEQ_VERIFICADOR',
        'CHEQ_ESTADO',
    ];

    public function cuentaBanco() {
        return $this->belongsTo(CuentaBanco::class, 'CUEB_NUMERO', 'CUEB_NUMERO');
    }

    public function Insert(){
        DB::table($this->table)->insert($this->toArray());
    }

    public function containCheque(){
        $result = false;
        if($this->CHEQ_PENDIENTES > 0){
            $result = true;
        } 
        return $result;
    }

    public function obtenerCheques(){
        $cheques = ChequeraMovimiento::where('CHEQ_ID', $this->CHEQ_ID)
            ->orderBy('CHEM_NUMERO', 'ASC')
            ->get();
        return $cheques;
    }

    public function obtenerEstado(){
        $chequeraEstado = [
            '0' => 'Sellada',
            '1' => 'Activa',
            '2' => 'Terminada',
            '3' => 'Archivada'
        ];
        return $chequeraEstado[$this->CHEQ_ESTADO];
    }

    public function archivarOArchivarChequera(){ 
        try {
            
            if($this->CHEQ_ESTADO == 2){
                $this->CHEQ_ESTADO = 3;
                $this->save();  
            }

            if($this->CHEQ_ESTADO == 0){
                $chequera = Chequera::where('CUEB_NUMERO', $this->CUEB_NUMERO)
                    ->where('CHEQ_ESTADO', 1)
                    ->first();
                if($chequera){
                    throw new Exception('No se puede activar la chequera porque hay chequeras activas en la cuenta bancaria');
                }
                $this->CHEQ_ESTADO = 1;
                $this->save();  
            }
        } catch (\Exception $th) {
            throw $th;
        } 
    }
}
