<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Cuotas;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Ignition\Contracts\Solution;

class SolicitudController extends Controller{

    public function index(){
        return Inertia::render('Administracion/Solicitud');
    }

    public function store(){
        return Inertia::render('Administracion/Solicitud');
    }


    public function findById($SOLI_ID){
        $solicitud = Solicitud::where('SOLI_ID', $SOLI_ID)
            ->with('plazo','formaPago', 'tipoCredito', 'garantia', 'tipoInteres', 'tasaInteres')->first(); 
        return response()->json( $solicitud );
    }

    public $interes = 0;
    public function findCuotas($SOLI_ID){
        $cuotas = Cuotas::where('SOLI_ID', $SOLI_ID)->get(); 

        $this->interes = Solicitud::where('SOLI_ID', $SOLI_ID)->first()->tasaInteres->TASA_VALOR;

        $cuotas->map(function($cuota){
            $cuota->CUOT_MORA =  date('Y-m-d') >= $cuota->CUOT_FECHAPAGO && $cuota->CUOT_ESTADO == 0 
                ? (floatval($this->interes) / 100) * $cuota->CUOT_MONTO : 0;  

            $cuota->DIAS_MORA = date('Y-m-d') >= $cuota->CUOT_FECHAPAGO && $cuota->CUOT_ESTADO == 0 ? (strtotime(date('Y-m-d')) - strtotime($cuota->CUOT_FECHAPAGO)) / (60 * 60 * 24) : 0;  
            return $cuota;
        });

        return response()->json( $cuotas );
    }


    public function findByIdClient($CLIE_ID, $TAKE){
        $solicitud = Solicitud::where('CLIE_ID', $CLIE_ID) 
            ->take($TAKE)->get(); 

        return response()->json( $solicitud );
    }
}
