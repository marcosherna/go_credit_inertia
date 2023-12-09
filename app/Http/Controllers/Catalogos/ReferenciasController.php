<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\Referencia;
use Illuminate\Http\Request;
use League\CommonMark\Reference\Reference;

class ReferenciasController extends Controller {

    public function index() {
    }

    public function store(Request $request){
        try {
            
            

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function exist($REFE_DUI){ 
        try {
            $isExist = Referencia::where('REFE_DUI', $REFE_DUI)->exists();
            return response()->json(['isExist' => $isExist]);
        } catch (\Throwable $th) {
            return response()->json($th);    
        }
    }
}
