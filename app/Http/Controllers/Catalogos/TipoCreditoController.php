<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\TipoCredito;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TipoCreditoController extends Controller {
    public function index() {
        return Inertia::render('Catalogos/TipoCreditos');
    }

    public function Combo(){
        $tipoCreditos = TipoCredito::select('TIPO_ID','TIPO_NOMBRE')
        ->where('TIPO_ESTADO', 1)
        ->get();  
        return response()->json($tipoCreditos);
    }
}
