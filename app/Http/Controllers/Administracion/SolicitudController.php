<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administracion\SolicitudRequest;
use App\Models\Cuotas;
use App\Models\Solicitud;
use DateInterval;
use DateTime;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\Ignition\Contracts\Solution;

class SolicitudController extends Controller{

    public function index(){
        return Inertia::render('Administracion/Solicitud');
    }

    public function store(SolicitudRequest $request){

        try {
            $solicitud = new Solicitud();    
            $solicitud->SOLI_FECHA = date('Y-m-d');
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
            $solicitud->SOLI_FECHAVENCIMIENTO = date($request->SOLI_FECHAVENCIMIENTO);
            $solicitud->SOLI_OBSERVACION = $request->SOLI_OBSERVACION;
            $solicitud->SOLI_CONDICIONES = $request->SOLI_CONDICIONES;
            $solicitud->SOLI_OTROS = null;
            $solicitud->SOLI_ESTADO = 98; // temporal;

            $solicitud->Insert(); 

            $soli = Solicitud::where('EMPL_ID', Auth::user()->EMPL_ID)
            ->where('CLIE_ID', $request->CLIE_ID)
            ->where('SOLI_FECHAVENCIMIENTO', date($request->SOLI_FECHAVENCIMIENTO))
            ->where('SOLI_MONTO', $request->SOLI_MONTO)
            ->where('TIPO_ID', $request->TIPO_ID)
            ->where('GARA_ID', $request->GARA_ID)
            ->where('PLAZ_ID', $request->PLAZ_ID)
            ->where('FORM_ID', $request->FORM_ID)
            ->where('TIPT_ID', $request->TIPT_ID)
            ->where('TASA_ID', $request->TASA_ID)
            ->where('SOLI_TIPOTASA', $request->SOLI_TIPOTASA)
            ->where('SOLI_OMITIRDOM', $request->SOLI_OMITIRDOM)
            ->where('SOLI_DISPERSAR', $request->SOLI_DISPERSAR)
            ->where('SOLI_CATEGORIA', $request->SOLI_CATEGORIA)
            ->where('SOLI_FECHAAPROB', null)
            ->where('SOLI_OBSERVACION', $request->SOLI_OBSERVACION)
            ->where('SOLI_CONDICIONES', $request->SOLI_CONDICIONES)
            ->where('SOLI_OTROS', null)
            ->where('SOLI_ESTADO', '=', 98)->first();

            return response()->json($soli);

        } catch (\Throwable $th) {
            return $th ;
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


    public function changedStatus($SOLI_ID, $SOLI_ESTADO){
        $solicitud = Solicitud::where('SOLI_ID', $SOLI_ID)->first(); 

        if($solicitud){
            $solicitud->SOLI_ESTADO = $SOLI_ESTADO;
            $solicitud->save(); 
        }   

        return response()->json( $solicitud );
    }

    public function find(SolicitudRequest $request){ 
        $solicitud = Solicitud::where('SOLI_ID', $request->SOLI_ID)
            ->orWhere('CLIE_ID', $request->CLIE_ID)
            ->orWhere('SOLI_FECHA', $request->SOLI_FECHA)
            ->orWhere('SOLI_MONTO', $request->SOLI_MONTO)
            ->orWhere('TIPO_ID', $request->TIPO_ID)
            ->orWhere('GARA_ID', $request->GARA_ID)
            ->orWhere('PLAZ_ID', $request->PLAZ_ID)
            ->orWhere('FORM_ID', $request->FORM_ID)
            ->orWhere('TIPT_ID', $request->TIPT_ID)
            ->orWhere('TASA_ID', $request->TASA_ID)
            ->orWhere('SOLI_TIPOTASA', $request->SOLI_TIPOTASA)
            ->orWhere('SOLI_OMITIRDOM', $request->SOLI_OMITIRDOM)
            ->orWhere('SOLI_DISPERSAR', $request->SOLI_DISPERSAR)
            ->orWhere('SOLI_CATEGORIA', $request->SOLI_CATEGORIA)
            ->orWhere('SOLI_FECHAAPROB', $request->SOLI_FECHAAPROB)
            ->orWhere('SOLI_FECHAVENCIMIENTO', $request->SOLI_FECHAVENCIMIENTO)
            ->orWhere('SOLI_OBSERVACION', $request->SOLI_OBSERVACION)
            ->orWhere('SOLI_CONDICIONES', $request->SOLI_CONDICIONES)
            ->orWhere('SOLI_OTROS', $request->SOLI_OTROS)
            ->orWhere('SOLI_ESTADO', $request->SOLI_ESTADO)
            ->get(); 
        return $solicitud;
    }

    public function search($query){
        $solicitud = Solicitud::where('SOLI_ID', 'LIKE', '%'.$query.'%')
            ->where('EMPL_ID', Auth::user()->EMPL_ID)
            ->where('SOLI_ESTADO', 0)
            ->orWhere('SOLI_FECHA', 'LIKE', '%'.$query.'%')
            ->orWhere('SOLI_MONTO', 'LIKE', '%'.$query.'%')
            ->orWhere('TIPO_ID', 'LIKE', '%'.$query.'%')
            ->orWhere('GARA_ID', 'LIKE', '%'.$query.'%')
            ->orWhere('PLAZ_ID', 'LIKE', '%'.$query.'%')
            ->orWhere('FORM_ID', 'LIKE', '%'.$query.'%')
            ->orWhere('TIPT_ID', 'LIKE', '%'.$query.'%')
            ->orWhere('TASA_ID', 'LIKE', '%'.$query.'%')
            ->orWhere('SOLI_TIPOTASA', 'LIKE', '%'.$query.'%')
            ->orWhere('SOLI_OMITIRDOM', 'LIKE', '%'.$query.'%')
            ->orWhere('SOLI_DISPERSAR', 'LIKE', '%'.$query.'%')
            ->orWhere('SOLI_CATEGORIA', 'LIKE', '%'.$query.'%')
            ->orWhere('SOLI_FECHAAPROB', 'LIKE', '%'.$query.'%')
            ->orWhere('SOLI_FECHAVENCIMIENTO', 'LIKE', '%'.$query.'%')
            ->orWhere('SOLI_OBSERVACION', 'LIKE', '%'.$query.'%')
            ->orWhere('SOLI_CONDICIONES', 'LIKE', '%'.$query.'%')
            ->orWhere('SOLI_OTROS', 'LIKE', '%'.$query.'%')
            
            ->paginate(10); 

            $solicitud->transform(function ($item) {
                $item->SOLI_MONTO = number_format($item->SOLI_MONTO, 2, ',', '.');
                $item->SOLI_CUOTA = number_format($item->SOLI_CUOTA, 2, ',', '.');
                $item->SOLI_PLAZO = number_format($item->SOLI_PLAZO, 2, ',', '.');
                $item->cliente->NOMBRE = $item->cliente->CLIE_NOMBRE . ' ' . $item->cliente->CLIE_NOMBRE2. ' ' . $item->cliente->CLIE_APELLIDO.' '. $item->cliente->CLIE_APELLIDO2;
                return $item;
            });

        return $solicitud;
    }

    public function edit($SOLI_ID, SolicitudRequest $request){
        try {
            $solicitud = Solicitud::where('SOLI_ID', $SOLI_ID)->first();
            $solicitud->SOLI_FECHA = date($request->SOLI_FECHA);
            $solicitud->EMPL_ID = $request->EMPL_ID;
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
            $solicitud->SOLI_FECHAAPROB = $request->SOLI_FECHAAPROB;
            $solicitud->SOLI_FECHAVENCIMIENTO = date($request->SOLI_FECHAVENCIMIENTO);;
            $solicitud->SOLI_OBSERVACION = $request->SOLI_OBSERVACION;
            $solicitud->SOLI_CONDICIONES = $request->SOLI_CONDICIONES;
            $solicitud->SOLI_OTROS = $request->SOLI_OTROS;
            $solicitud->SOLI_ESTADO = $request->SOLI_ESTADO;
            $solicitud->save();
            
            return response()->json($solicitud);
        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }
}
