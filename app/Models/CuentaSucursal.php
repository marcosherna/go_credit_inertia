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
    
    public function cuentaMovimientoSucursal() {
        return $this->hasMany(CuentaMovimientoSucursal::class, 'CUEN_ID', 'CUEN_ID');
    }

    public function getBolsa($SUCU_ID = null, $CUEN_ID = null) {
        $id = $SUCU_ID == null ? $this->SUCU_ID : $SUCU_ID;
        $cuenta = null;
        $query = CuentaSucursal::select('CUEN_ID', 'CUEN_SALDO', 'CUEN_ESTADO')
            ->where('SUCU_ID', $id)
            ->where('CUEN_TIPO', 1);

        if ($CUEN_ID != null) {
            $query->where('CUEN_ID', $CUEN_ID);
        }

        $cuenta = $query->first();
        
        return $cuenta;
    }


    public function Desembolos(){ 
        $cuenta = $this->getBolsa();
        $movimiento = new CuentaMovimientoSucursal();
        $movimiento->CUEN_ID = $cuenta->CUEN_ID;
        $movimiento->CUEM_FECHA = date('Y-m-d');
        $movimiento->CUEM_HORA = date('H:i:s');
        $movimiento->CUEM_TIPOMOV = 2;
        $movimiento->CUEM_SALDOINI = $cuenta->CUEN_SALDO;
        $movimiento->CUEM_CARGO = 0;
        $movimiento->CUEM_ABONO = 0;
        $movimiento->CUEM_SALDOFIN = $cuenta->CUEN_SALDO;
        $movimiento->CUEM_DETALLE = 'Desembolso de Credito No. ' . $cuenta->CUEN_ID;
        $movimiento->CUEM_ESTADO = 1;

        if($cuenta != null){
            $movimiento =  $movimiento->setMovimiento();

            if($movimiento->CUEM_ID != null){
                $cuenta->CUEN_SALDO = $movimiento->CUEM_SALDOFIN;
                $cuenta->save();

                $transaccion = new Transacciones();  
                $transaccion->TIPT_ID = TipoTransaccion::where('TIPT_NOMBRE', 'DESEMBOLSO')
                    ->where('TIPT_DETALLE', 'Desembolso de Crédito')->first()->TIPT_ID; 
                $transaccion->TRAN_FECHA = date('Y-m-d');
                $transaccion->TRAN_HORA = date('H:i:s');
                $transaccion->TRAN_MONTO = $movimiento->CUEM_ABONO;
                $transaccion->TRAN_DETALLE = $movimiento->CUEM_DETALLE;
                $transaccion->TRAN_REFERENCIA = $cuenta->SUCU_ID;
                $transaccion->TRAN_RESPUESTA = 'TRANSACCION EXITOSA';
                $transaccion->TRAN_ESTADO = '00';
                $transaccion->insert();

            }
        }
    } 


 
}
