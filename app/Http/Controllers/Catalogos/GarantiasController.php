<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\Garantia;
use Illuminate\Http\Request;

class GarantiasController extends Controller {
    
    public function combo(){
        $garantias = Garantia::select('GARA_ID','GARA_NOMBRE')
        ->where('GARA_ESTADO', 1)
        ->get();  
        return response()->json($garantias);
    }
}
