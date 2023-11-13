<?php

namespace App\Http\Controllers\CuentaBanco;

use App\Http\Controllers\Controller;
use App\Models\CuentaBanco; 
use Inertia\Inertia;

class CuentaBancoController extends Controller {

    public function index() {
        $cuentasBanco = CuentaBanco::with('banco:BANC_ID,BANC_NOMBRE','tipoCuenta:TIPO_ID,TIPO_NOMBRE','cuentaSucursal:CUEN_ID,  CUEN_NOMBRE')->get();
        
        return Inertia::render('Banco/CuentaBanco', ['cuentasBanco' => $cuentasBanco]);
    }
}
