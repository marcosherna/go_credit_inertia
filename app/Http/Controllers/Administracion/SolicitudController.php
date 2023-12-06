<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Cuotas;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\Ignition\Contracts\Solution;

class SolicitudController extends Controller{

    public function index(){
        return Inertia::render('Administracion/Solicitud');
    }

    public function store(Request $request){

        try {
            $solicitud = new Solicitud();   
            $solicitud->SOLI_FECHA = $request->SOLI_FECHA;
            $solicitud->EMPL_ID = Auth::user()->EMPL_ID;
            $solicitud->CLIE_ID = $request->CLIE_ID;
            $solicitud->SOLI_MONTO = $request->SOLI_MONTO;
            $solicitud->TIPO_ID = $request->TIPO_ID;
            $solicitud->GARA_ID = $request->GARA_ID;
            $solicitud->PLAZ_ID = $request->PLAZ_ID;
            $solicitud->FORM_ID = $request->FORM_ID;
            $solicitud->TIPT_ID = $request->TIPT_ID;
            $solicitud->TASA_ID = $request->TASA_ID;
            $solicitud->SOLI_TIPOTASA = $request->SOLI_TIPOTASA;
            $solicitud->SOLI_OMITIRDOM = $request->SOLI_OMITIRDOM;
            $solicitud->SOLI_DISPERSAR = $request->SOLI_DISPERSAR;
            $solicitud->SOLI_CATEGORIA = $request->SOLI_CATEGORIA;
            $solicitud->SOLI_FECHAAPROB = null;
            $solicitud->SOLI_FECHAVENCIMIENTO = $request->SOLI_FECHAVENCIMIENTO;
            $solicitud->SOLI_OBSERVACION = $request->SOLI_OBSERVACION;
            $solicitud->SOLI_CONDICIONES = $request->SOLI_CONDICIONES;
            $solicitud->SOLI_OTROS = null;
            $solicitud->SOLI_ESTADO = $request->SOLI_ESTADO; 
            
            return response()->json( $solicitud );
        } catch (\Throwable $th) {
            throw $th;
        }
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
