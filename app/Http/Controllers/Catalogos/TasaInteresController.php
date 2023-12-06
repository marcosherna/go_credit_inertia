<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\TasaInteres;
use Illuminate\Http\Request;

class TasaInteresController extends Controller {
    public function combo(){ 
        $tazaInteres = TasaInteres::select('TASA_ID', 'TASA_VALOR')
            ->where('TASA_ESTADO', 1)
            ->get();
            
        return response()->json($tazaInteres);
    }   
}
