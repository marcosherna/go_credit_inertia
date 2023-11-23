<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\EstadoCivil;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EstadoCivilController extends Controller {

    public final function index() {
        return Inertia::render('Catalogos/EstadoCivil');
    }


    public function findAll(){
        $estadosCiviles = EstadoCivil::select('ESTA_ID','ESTA_NOMBRE','ESTA_ESTADO')->get();
        return response()->json($estadosCiviles);
    }
}
