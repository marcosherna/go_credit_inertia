<?php

namespace App\Http\Requests\Banco;

use Illuminate\Foundation\Http\FormRequest;

class ChequeRequest extends FormRequest {

    public function authorize(){
        return true;
    }

    public function rules() {
        return [
            'CHEM_ID' => 'nullable',
            'CHEQ_ID' => 'required',
            'CHEM_NUMERO' => 'required',
            'CHEM_FECHA' => 'nullable',
            'CHEM_LUGAR' => 'required',
            'CHEM_MONTO' => 'required|numeric|min:0',
            'CHEM_NOMBRE' => 'required',
            'CHEM_MONTOLETRA' => 'required',
            'CHEM_COMENTARIOS' => 'nullable',
            'CHEM_FECHACAMBIO' => 'nullable',
            'USUA_ID' => 'nullable',
            'CHEM_ESTADO' => 'nullable',
        ];
    }
}
