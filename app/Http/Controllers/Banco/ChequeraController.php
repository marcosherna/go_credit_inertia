<?php

namespace App\Http\Controllers\Banco;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banco\ChequeraRequest;
use App\Http\Requests\Banco\ChequeRequest;
use App\Models\Chequera;
use App\Models\ChequeraMovimiento;
use App\Models\CuentaBanco;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChequeraController extends Controller {
    public function __invoke() {
        
    }   
    
    public function index() { 
        $chequeras = Chequera::with('cuentaBanco.banco:BANC_ID,BANC_NOMBRE') 
            ->orderBy('CHEQ_ID', 'desc')
            ->get();
            
        return Inertia::render('Banco/Chequera', [
            'cuentasBanco' => CuentaBanco::select('CUEB_NUMERO', 'BANC_ID')->with('banco:BANC_ID,BANC_NOMBRE')->get(),
            'chequeras' => $chequeras,
        ]);
    }

    public function store(ChequeraRequest $request) { 
        $chequera = new Chequera();
        $chequera->CUEB_NUMERO = $request->CUEB_NUMERO;
        $chequera->CHEQ_DESDE = $request->CHEQ_DESDE;
        $chequera->CHEQ_HASTA = $request->CHEQ_HASTA;
        $chequera->CHEQ_CANTIDAD = $request->CHEQ_CANTIDAD;
        $chequera->CHEQ_PENDIENTES = $request->CHEQ_PENDIENTES;
        $chequera->CHEQ_REFERENCIA = $request->CHEQ_REFERENCIA;
        $chequera->CHEQ_FECHA = date('Y-m-d H:i:s');
        $chequera->CHEQ_GENERACION = $request->CHEQ_GENERACION;
        $chequera->CHEQ_VERIFICADOR = $request->CHEQ_VERIFICADOR;
        $chequera->CHEQ_ESTADO = 0;
        
        $chequera->Insert();

        return redirect()->back()
            ->with('message', 'Chequera agregada.');
    }

    public function getCheques($CHEQ_ID) {
        $chequera = Chequera::find($CHEQ_ID); 
        return response()->json($chequera->obtenerCheques());
    }

    public function createCheque(ChequeRequest $request){
        try {
            $cheque = new ChequeraMovimiento();

            $cheque->CHEQ_ID = $request->CHEQ_ID;
            $cheque->CHEM_NUMERO = $request->CHEM_NUMERO;
            $cheque->CHEM_FECHA = date('Y-m-d H:i:s');
            $cheque->CHEM_FECHACAMBIO = null;
            $cheque->USUA_ID = auth()->user()->USUA_ID;
            $cheque->CHEM_ESTADO = 0;
            $cheque->emitCheque();
            return response()->json($cheque);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}
