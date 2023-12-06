<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\FormaPago;
use Illuminate\Http\Request;

class FormaPagoController extends Controller {
    public function combo(){
        $formaPago = FormaPago::select('FORM_ID', 'FORM_NOMBRE')
            ->where('FORM_ESTADO', 1)
            ->get();
        return response()->json($formaPago);
    }
}
