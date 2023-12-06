<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\Plazo;
use Illuminate\Http\Request;

class PlazosController extends Controller {
        
        public function combo(){
            $plazos = Plazo::select('PLAZ_ID','PLAZ_NOMBRE')->get();  
            return response()->json($plazos);
        }
}
