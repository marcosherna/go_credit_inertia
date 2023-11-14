<?php

namespace App\Http\Controllers\Banco;

use App\Http\Controllers\Controller;
use App\Models\Chequera;
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
}
