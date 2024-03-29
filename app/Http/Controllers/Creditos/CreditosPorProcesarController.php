<?php

namespace App\Http\Controllers\Creditos;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CreditosPorProcesarController extends Controller {

    public $solicitudes; 

    public function index() { 
        $this->solicitudes = Solicitud::where('SOLI_ESTADO', '=', 1)
            ->where('SOLI_FECHAAPROB', '=', null)
            ->where('EMPL_ID', '=', Auth::user()->EMPL_ID) 
            ->paginate(10);

            $this->solicitudes->transform(function ($item) {
                $item->SOLI_MONTO = number_format($item->SOLI_MONTO, 2, ',', '.');
                $item->SOLI_CUOTA = number_format($item->SOLI_CUOTA, 2, ',', '.');
                $item->SOLI_PLAZO = number_format($item->SOLI_PLAZO, 2, ',', '.');
                $item->cliente->NOMBRE = $item->cliente->CLIE_NOMBRE . ' ' . $item->cliente->CLIE_NOMBRE2. ' ' . $item->cliente->CLIE_APELLIDO.' '. $item->cliente->CLIE_APELLIDO2;
                $item->cliente->EMAIL = $item->cliente->getMail();
                $item->cliente->TELEFONOS = $item->cliente->getTelefonos();

                $item->empleado->NOMBRE = $item->empleado->EMPL_NOMBRE . ' ' . $item->empleado->EMPL_NOMBRE2. ' ' . $item->empleado->EMPL_APELLIDO.' '. $item->empleado->EMPL_APELLIDO2;
                
                $item->garantia->NOMBRE = $item->garantia->GARA_NOMBRE;

                $item->plazo = $item->plazo->PLAZ_NOMBRE;
                $item->formaPago = $item->formaPago->FORM_NOMBRE;
                

                return $item;
            });

        return Inertia::render('Creditos/SolicitudPorProcesar',[
            'response' => $this->solicitudes, 
            'count' => $this->solicitudes->count(),
        ]);
    }

    public function observarCredito(Request $request){
        $solicitud = Solicitud::find($request->SOLI_ID);
        $solicitud->SOLI_OBSERVACION = $request->SOLI_OBSERVACION;
        $solicitud->SOLI_ESTADO = 0;
        $solicitud->save();
        return response()->json([
            'message' => 'Solicitud observada con exito',
            'status' => 200
        ]);
    }
}
