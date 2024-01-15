<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class CuentaMovimientoSucursal extends Model {
    use HasUlids;
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
        'CUEM_TIPOMOV', // Tipo Registro: 0-Creacion Bolsa 1-Aporte Capital 2-Desembolso Credito 3-Pago Cuota 4-Pago Interes 5-Capitalizacion
        'CUEM_SALDOINI',
        'CUEM_ABONO',
        'CUEM_CARGO',
        'CUEM_SALDOFIN',
        'CUEM_DETALLE',
        'CUEM_ESTADO',  // Estado Transaccion: 0-Anulada 1-Aplicada 2-Flotante
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


    public function Insert() {
        DB::table($this->table)->insert($this->toArray());
    }

    //Obtengo Ultima Transaccion
    //FAusto Sandoval    
    public function getUltimoMovBolsa($idBolsa=null) {

        $id = $idBolsa == null ? $this->CUEN_ID : $idBolsa;
        $cuenta = CuentaMovimientoSucursal::select('CUEM_ID', 'CUEM_SALDOFIN', 'CUEN_ID')
            ->where('CUEN_ID', $id)
            ->orderBy('CUEM_ID', 'desc')
            ->first();
        return $cuenta;
    }

    public function setMovimiento(){

        try {
            $ultimoMovimiento = $this->getUltimoMovBolsa(); 
            if($ultimoMovimiento != null){
                $saldo = floatval($ultimoMovimiento->CUEM_SALDOFIN) + floatval($this->CUEM_ABONO);
                $this->CUEM_SALDOINI = $ultimoMovimiento->CUEM_SALDOFIN;
                $this->CUEM_SALDOFIN = $saldo;
                
                if($this->CUEM_TIPOMOV ==  1 || $this->CUEM_TIPOMOV ==  3 || $this->CUEM_TIPOMOV ==  5 ){
                    $this->CUEM_CARGO = 0;
                    $this->Insert();
                }else if ($this->CUEM_TIPOMOV == 2 || $this->CUEM_TIPOMOV == 4){
                    $saldo = floatval($ultimoMovimiento->CUEM_SALDOFIN) - floatval($this->CUEM_ABONO);
                    $this->CUEM_CARGO = $this->CUEM_ABONO;
                    $this->Insert();
                }


            }else{
                $this->CUEM_SALDOINI = 0;
                $this->CUEM_SALDOFIN = $this->CUEM_ABONO;
            }
            return $this;
        } catch (\Exception $exeption) {
            throw $exeption;
        }
        
    }
}
