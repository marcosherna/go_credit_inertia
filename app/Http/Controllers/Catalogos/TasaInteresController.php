<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\TasaInteres;
use Illuminate\Http\Request;

class TasaInteresController extends Controller {
    public function combo(){ 
        $tazaInteres = TasaInteres::where('TASA_ESTADO', 1)
            ->get();

        $tazaInteres->transform(function ($item) {
            $item->TASA = $item->TASA_TIPO;
            return [
                'TASA_ID' => $item->TASA_ID,
                'TASA_VALOR' => $item->TASA_VALOR,
                'TASA' => $item->getTasa()
            ];
        });
            
        return response()->json($tazaInteres);
    }   
}
