<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuotas extends Model {

    protected $table = 'cuotas';
    protected $primaryKey = 'CUOT_ID';
    public $timestamps = false; // Si no necesitas campos created_at y updated_at

    protected $fillable = [
        'SOLI_ID',
        'CUOT_FECHAPAGO',
        'CUOT_NUMERO',
        'CUOT_MONTO',
        'CUOT_CAP',
        'CUOT_INT',
        'CUOT_SEG',
        'CUOT_OTRO',
        'CUOT_ABONO',
        'CUOT_CAPITAL',
        'CUOT_INTERES',
        'CUOT_MORA',
        'CUOT_SEGUROS',
        'CUOT_PENALIDAD',
        'CUOT_BONIFICACION',
        'CUOT_FECHAREC',
        'CUOT_ESTADO',
        'CUOT_MORA_ESTADO',
    ];
    //Estado de Pago. 0-Pendiente 1-Aplicado 2-Anulado/Pendiente 3-Devuelto/Pendiente 4-Aplicado por pago anticipado 
    private $estados = [
        0 => ['NOMBRE' => 'Pendiente','VALOR' => 0],
        1 => ['NOMBRE' => 'Aplicado','VALOR' => 1],
        2 => ['NOMBRE' => 'Anulado/Pendiente','VALOR' => 2],
        3 => ['NOMBRE' => 'Devuelto/Pendiente','VALOR' => 3],
        4 => ['NOMBRE' => 'Aplicado por pago anticipado','VALOR' => 4],
    ];

    public function solicitud() {
        return $this->belongsTo(Solicitud::class, 'SOLI_ID', 'SOLI_ID');
    }  

    public function estado(){
        return $this->estados[(intval($this->CUOT_ESTADO))];
    }

    public function diasVencidos(){
        $fechaActual = date('Y-m-d');
        $fechaVencimiento = $this->CUOT_FECHAPAGO;
        $dias = (strtotime($fechaActual)-strtotime($fechaVencimiento))/86400;
        $dias = abs($dias); $dias = floor($dias);
        return $this->CUOT_ESTADO == 0 ? $dias : 0;
    }

 
}
