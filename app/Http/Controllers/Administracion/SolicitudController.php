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

    public function findCuotas($SOLI_ID){
        $cuotas = Cuotas::where('SOLI_ID', $SOLI_ID)->get(); 
        return response()->json( $cuotas );
    }

    public function findByIdClient($CLIE_ID, $TAKE){
        $solicitud = Solicitud::where('CLIE_ID', $CLIE_ID) 
            ->take($TAKE)->get(); 

        return response()->json( $solicitud );
    }
}
