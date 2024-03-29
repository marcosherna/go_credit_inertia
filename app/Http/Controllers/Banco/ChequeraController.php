<?php

namespace App\Http\Controllers\Banco;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banco\ChequeraRequest;
use App\Http\Requests\Banco\ChequeRequest;
use App\Http\Requests\Errors\ErrorResponse;
use App\Models\Chequera;
use App\Models\ChequeraMovimiento;
use App\Models\CuentaBanco;
use Error;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChequeraController extends Controller {
    public function __invoke() {
        
    }   
    
    public function index() { 
        $chequeras = Chequera::with('cuentaBanco.banco:BANC_ID,BANC_NOMBRE') 
            ->orderBy('CHEQ_ID', 'desc')
            ->paginate(10);
            
        return Inertia::render('Banco/Chequera', [
            'cuentasBanco' => CuentaBanco::select('CUEB_NUMERO', 'BANC_ID')->with('banco:BANC_ID,BANC_NOMBRE')->get(),
            'paginate' => $chequeras,
        ]);
    }

    public function store(ChequeraRequest $request) {  
        try {
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

        } catch (\Throwable $th) {
            throw $th;
        } 
    }

    public function getCheques($CHEQ_ID) {
        $chequera = Chequera::find($CHEQ_ID); 
        return response()->json($chequera->obtenerCheques());
    }

    public function createCheque(ChequeRequest $request){ 
        try {
            $cheque = new ChequeraMovimiento();

            $cheque->CHEM_ID = date('YmdHis');
            $cheque->CHEQ_ID = $request->CHEQ_ID;
            $cheque->CHEM_NUMERO = $request->CHEM_NUMERO;
            $cheque->CHEM_FECHA = $request->CHEM_FECHA;
            $cheque->CHEM_LUGAR = $request->CHEM_LUGAR;
            $cheque->CHEM_MONTO = $request->CHEM_MONTO;
            $cheque->CHEM_NOMBRE = $request->CHEM_NOMBRE;
            $cheque->CHEM_MONTOLETRA = $request->CHEM_MONTOLETRA;
            $cheque->CHEM_COMENTARIOS = $request->CHEM_COMENTARIOS;
            $cheque->CHEM_FECHACAMBIO = date('Y-m-d H:i:s');
            $cheque->USUA_ID = auth()->user()->EMPL_ID;
            $cheque->CHEM_ESTADO = 0; 
            $cheque->emitCheque(); 
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function cambiarEstadoChequera($CHEQ_ID){
        try{
            $chequera = Chequera::find($CHEQ_ID);
            $chequera->archivarOArchivarChequera();

        } catch (\Exception $th) {
            $error = new ErrorResponse();
            $error->code = 500;
            $error->message = $th->getMessage();
            $error->error = $th;
            return response()->json($error);
        }
    }
}
