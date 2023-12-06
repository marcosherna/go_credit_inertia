<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\TipoInteres;
use Illuminate\Http\Request;

class TipoInteresController extends Controller {
    public function combo(){
        $tipoInteres = TipoInteres::select('TIPO_ID', 'TIPO_NOMBRE')
            ->where('TIPO_ESTADO', 1)
            ->get();
        
        return response()->json($tipoInteres);
    }
}
